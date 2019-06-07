<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Generator;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Generator\File\Reader;
use Brotkrueml\Schema\Generator\File\Writer;
use Brotkrueml\Schema\Generator\Model\Property;
use Brotkrueml\Schema\Generator\Model\Type;

class Generator
{
    protected $modelsToGenerate = [];
    protected $schemaDefinition;
    protected $schemaVersion;

    /**
     * @var Writer[]
     */
    protected $writers = [];

    /**
     * @var Type[]
     */
    protected $types = [];

    protected $generatedTypes = [];

    public function __construct($schemaPath)
    {
        $this->schemaDefinition = \json_decode((new Reader($schemaPath))->read(), true);
    }

    public function addWriter(Writer $writer): self
    {
        $this->writers[] = $writer;

        return $this;
    }

    public function generate(): void
    {
        $this->determineSchemaVersion();
        $this->collectTypes();
        $this->collectProperties();
        $this->createSchemaClasses();
    }

    protected function determineSchemaVersion(): void
    {
        $this->schemaVersion = \str_replace('http://schema.org/#', '', $this->schemaDefinition['@id']);
    }

    protected function collectTypes(): void
    {
        foreach ($this->schemaDefinition['@graph'] as $element) {
            if (isset($element['http://schema.org/supersededBy'])) {
                continue;
            }

            if ($element['@id'] === 'http://schema.org/DataType') {
                continue;
            }

            if (strpos($element['rdfs:comment'], 'Data type:') === 0) {
                continue;
            }

            if ($element['@type'] === 'rdfs:Class') {
                $this->processType($element);
            }
        }
    }

    protected function processType(array $element): void
    {
        $id = $element['@id'];

        $this->types[$id] = new Type();
        $this->types[$id]->id = $element['@id'];
        $this->types[$id]->label = $element['rdfs:label'];
        $this->types[$id]->comment = $element['rdfs:comment'];
        $this->types[$id]->properties = [];

        if (\array_key_exists('rdfs:subClassOf', $element)) {
            $subClasses = [];

            if (\array_key_exists('@id', $element['rdfs:subClassOf'])) {
                $subClasses[] = $element['rdfs:subClassOf']['@id'];
            } else {
                foreach ($element['rdfs:subClassOf'] as $subClass) {
                    $subClasses[] = $subClass['@id'];
                }
            }

            $this->types[$id]->subClassOf = $subClasses;
        }
    }

    protected function collectProperties(): void
    {
        foreach ($this->schemaDefinition['@graph'] as $element) {
            if (isset($element['http://schema.org/supersededBy'])) {
                continue;
            }

            if ($element['@type'] === 'rdf:Property') {
                $this->processProperty($element);
            }
        }
    }

    // @todo auflösen/entfernen
    protected function buildLabelFromId(string $id): string
    {
        return \str_replace('http://schema.org/', '', $id);
    }

    protected function processProperty(array $element): void
    {
        $property = new Property();
        $property->id = $element['@id'];
        $property->label = $element['rdfs:label'];
        $property->comment = $element['rdfs:comment'];

        foreach ($element['http://schema.org/domainIncludes'] as $domain) {
            if (\gettype($domain) === 'array') {
                $type = $domain['@id'];
            } else {
                $type = $domain;
            }

            if (!\array_key_exists($type, $this->types)) {
                // Could be a superseded type
                continue;
            }

            $this->types[$type]->properties[$property->label] = $property;
        }
    }

    protected function createSchemaClasses(): void
    {
        foreach ($this->types as $type) {
            if (\in_array($type->id, $this->generatedTypes)) {
                continue;
            }

            $this->createSchemaClass($type->id);
        }
    }

    protected function createSchemaClass(string $type): void
    {
        if (!\array_key_exists($type, $this->types)) {
            // Because of DataType
            return;
        }

        $subClasses = $this->types[$type]->subClassOf;

        if (\count($subClasses) && !\in_array($subClasses[0], $this->generatedTypes)) {
            $this->createSchemaClass($subClasses[0]);
        }

        if (\count($subClasses) > 1) {
            \array_shift($subClasses);
            foreach ($subClasses as $subClass) {
                if (!\array_key_exists($subClass, $this->types)) {
                    continue;
                }

                $this->types[$type]->properties = \array_merge($this->types[$type]->properties, $this->types[$subClass]->properties);
            }
        }

        $this->removeDuplicatePropertiesInHierarchy($type);

        $placeholders = [
            '###COMMENT###' => $this->shortenAndSanatizeComment($this->types[$type]->comment),
            '###VERSION###' => $this->schemaVersion,
            '###MODEL_CLASS###' => $this->types[$type]->label,
            '###MODEL_EXTENDS###' => \count($this->types[$type]->subClassOf) ? $this->types[$this->types[$type]->subClassOf[0]]->label : '\\Brotkrueml\\Schema\\Core\\Model\\AbstractType',
            '###MODEL_PROPERTIES###' => $this->getModelProperties($this->types[$type]->properties),
            '###VIEWHELPER_CLASS###' => $this->types[$type]->label . 'ViewHelper',
            '###VIEWHELPER_EXTENDS###' => \count($this->types[$type]->subClassOf) ? $this->types[$this->types[$type]->subClassOf[0]]->label . 'ViewHelper' : '\\Brotkrueml\\Schema\\Core\\ViewHelper\\AbstractTypeViewHelper',
            '###VIEWHELPER_ARGUMENTS###' => $this->getViewHelperArguments($this->types[$type]->properties),
        ];

        foreach ($this->writers as $writer) {
            $writer
                ->setPlaceholders($placeholders)
                ->write($this->types[$type]->label);
        }

        $this->generatedTypes[] = $this->types[$type]->id;

        echo "Successfully generated model and view helper of type " . $type . "\n";
    }

    /**
     * Sometimes there is a property defined in a sub class type which is also defined
     * in the parent type. This can cause harm in the view helper.
     *
     * @param string $typeId
     */
    protected function removeDuplicatePropertiesInHierarchy(string $typeId): void
    {
        if (count($this->types[$typeId]->subClassOf) === 0) {
            return;
        }

        foreach ($this->types[$typeId]->properties as $propertyId => $property) {
            $subClassTypeId = $this->types[$typeId]->subClassOf[0];

            if (\array_key_exists($propertyId, $this->types[$subClassTypeId]->properties)) {
                unset($this->types[$typeId]->properties[$propertyId]);
            }
        }
    }

    protected function shortenAndSanatizeComment(string $comment): string
    {
        $tokenizedComment = \explode("\n", \str_replace("'", "\\'", \strip_tags($comment)));

        return $tokenizedComment[0];
    }

    protected function getModelProperties(array $properties): string
    {
        if (count($properties) === 0) {
            return '';
        }

        $propertyLabels = \array_reduce(
            $properties,
            function ($carry, $item) {
                $carry[] = "'" . $item->label . "'";

                return $carry;
            },
            []
        );

        \sort($propertyLabels);

        return '$this->addProperties(' . \trim(\implode(",", $propertyLabels)) . ');';
    }

    protected function getViewHelperArguments(array $properties): string
    {
        \ksort($properties);

        $arguments = '';
        foreach ($properties as $property) {
            $arguments .= sprintf(
                "\$this->registerArgument('%s', '%s', '%s');",
                $property->label,
                'mixed',
                $this->shortenAndSanatizeComment($property->comment)
            );
        }

        return $arguments;
    }
}
