<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Generator;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Generator\Configuration\Configuration;
use Brotkrueml\Schema\Generator\File\Reader;
use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Twig\Environment;

class Generator
{
    protected const ROOT_TYPE_ID = 'http://schema.org/Thing';
    protected const ROOT_WEBPAGE_TYPE_ID = 'http://schema.org/WebPage';
    protected const ROOT_WEBPAGEELEMENT_TYPE_ID = 'http://schema.org/WebPageElement';

    protected const ATTRIBUTE_SUBTYPE_OF = 'rdfs:subClassOf';
    protected const ATTRIBUTE_COMMENT = 'rdfs:comment';
    protected const ATTRIBUTE_LABEL = 'rdfs:label';

    /** @var Configuration */
    protected $configuration;

    protected $schemaDefinition;

    /** @var Environment */
    protected $twig;

    protected $dataTypeIds = [
        'http://schema.org/Boolean',
        'http://schema.org/DataType',
        'http://schema.org/Date',
        'http://schema.org/DateTime',
        'http://schema.org/Float',
        'http://schema.org/Integer',
        'http://schema.org/Number',
        'http://schema.org/Text',
        'http://schema.org/Time',
        'http://schema.org/URL',
    ];

    /** @var Graph */
    protected $graph;

    /** @var Vertex[] */
    protected $types = [];

    protected $webPageTypes = [];
    protected $webPageElementTypes = [];

    protected $properties = [];

    public function __construct(Configuration $configuration, Environment $twig)
    {
        $this->configuration = $configuration;

        $this->schemaDefinition = \json_decode((new Reader($this->configuration->schemaPath))->read(), true);

        if (\is_null($this->schemaDefinition)) {
            throw new \RuntimeException(sprintf(
                'Could not read schema with path "%s" or decode to json',
                $this->configuration->schemaPath
            ));
        }

        $this->twig = $twig;

        $this->graph = new Graph();
    }

    public function generate(): void
    {
        $this->evaluateSchema();
        $this->buildGraph();
        $this->attachPropertiesToTypes();
        $this->identifyWebPageTypes();
        $this->identifyWebPageElementTypes();
        $this->createTypes();
    }

    protected function evaluateSchema(): void
    {
        foreach ($this->schemaDefinition['@graph'] as $term) {
            $id = $term['@id'];
            $type = $term['@type'];

            unset($term['@id']);
            unset($term['@type']);

            if (\in_array($id, $this->dataTypeIds)) {
                continue;
            }

            if (\array_key_exists('http://schema.org/supersededBy', $term)) {
                continue;
            }

            if ($type === 'rdfs:Class') {
                $this->types[$id] = $this->graph->createVertex($id);

                foreach ($term as $key => $value) {
                    $this->types[$id]->setAttribute($key, $value);
                }
            }

            if ($type === 'rdf:Property') {
                $this->properties[$id] = $term;
            }
        }
    }

    protected function buildGraph(): void
    {
        foreach ($this->types as $id => $type) {
            $subTypes = $type->getAttribute(self::ATTRIBUTE_SUBTYPE_OF);

            if ($subTypes === null) {
                continue;
            }

            if (\array_key_exists('@id', $subTypes)) {
                // only one sub type exists

                if (!\array_key_exists($subTypes['@id'], $this->types)) {
                    echo $subTypes['@id'] . ' does not exist! Called from ' . $type->getId() . "\n";
                    continue;
                }

                $this->types[$subTypes['@id']]->createEdgeTo($type);
                continue;
            }

            foreach ($subTypes as $subType) {
                if (!\array_key_exists($subType['@id'], $this->types)) {
                    echo $subType['@id'] . ' does not exist! Called from ' . $type->getId() . "\n";
                    continue;
                }

                $this->types[$subType['@id']]->createEdgeTo($type);
            }
        }
    }

    protected function attachPropertiesToTypes(): void
    {
        foreach ($this->properties as $propertyId => $property) {
            if (!\array_key_exists('http://schema.org/domainIncludes', $property)) {
                continue;
            }

            if (\count($property['http://schema.org/domainIncludes']) === 1) {
                $typeIds = [$property['http://schema.org/domainIncludes']['@id']];
            } else {
                $typeIds = [];
                foreach ($property['http://schema.org/domainIncludes'] as $type) {
                    $typeIds[] = $type['@id'];
                }
            }

            foreach ($typeIds as $typeId) {
                if (!\array_key_exists($typeId, $this->types)) {
                    continue;
                }

                $typeProperties = $this->types[$typeId]->getAttribute('properties', []);
                $typeProperties[$propertyId] = $property;
                $this->types[$typeId]->setAttribute('properties', $typeProperties);
            }
        }
    }

    protected function createTypes(): void
    {
        $this->createType($this->types[static::ROOT_TYPE_ID]);
        $this->createListOfAvailableTypes($this->types[static::ROOT_TYPE_ID]);
    }

    protected function createType(Vertex $type): void
    {
        $label = (string)$type->getAttribute(self::ATTRIBUTE_LABEL);
        $comment = $this->shortenAndSanatiseComment((string)$type->getAttribute(self::ATTRIBUTE_COMMENT));

        $properties = $this->getPropertiesForType($type);

        $typeClass = $this->twig->render(
            'Type.php.twig',
            [
                'comment' => $comment,
                'className' => $label,
                'properties' => $properties,
                'isWebPageType' => \in_array($label, $this->webPageTypes),
                'isWebPageElementType' => \in_array($label, $this->webPageElementTypes),
            ]
        );

        \file_put_contents(
            \sprintf(
                $this->configuration->modelTypePathTemplate,
                $label
            ),
            $typeClass
        );

        $viewHelperClass = $this->twig->render(
            'ViewHelper.php.twig',
            [
                'comment' => $comment,
                'type' => $label,
            ]
        );

        \file_put_contents(
            \sprintf(
                $this->configuration->viewHelperTypePathTemplate,
                $label
            ),
            $viewHelperClass
        );

        foreach ($type->getEdgesOut() as $edge) {
            $this->createType($edge->getVertexEnd());
        }
    }

    protected function shortenAndSanatiseComment(string $comment): string
    {
        $tokenisedComment = \explode("\n", \str_replace("'", "\\'", \strip_tags($comment)));

        return $tokenisedComment[0];
    }

    protected function getPropertiesForType(Vertex $type)
    {
        $properties = $this->getModelProperties((array)$type->getAttribute('properties'));

        foreach ($type->getEdgesIn() as $edge) {
            $properties = \array_merge($properties, $this->getPropertiesForType($edge->getVertexStart()));
        }

        $properties = \array_unique($properties);
        \sort($properties);

        return $properties;
    }

    protected function getModelProperties(array $properties): array
    {
        if (\count($properties) === 0) {
            return [];
        }

        $propertyLabels = \array_reduce(
            $properties,
            function ($carry, $item) {
                $carry[] = $item[self::ATTRIBUTE_LABEL];

                return $carry;
            },
            []
        );

        \sort($propertyLabels);

        return $propertyLabels;
    }

    protected function identifyWebPageTypes(): void
    {
        $this->webPageTypes = $this->getWebPageTypeChildren($this->types[static::ROOT_WEBPAGE_TYPE_ID]);
        \sort($this->webPageTypes);
    }

    protected function getWebPageTypeChildren(Vertex $type): array
    {
        $types = [$type->getAttribute(static::ATTRIBUTE_LABEL)];

        /** @var Directed $edge */
        foreach ($type->getEdgesOut() as $edge) {
            $types = \array_merge($types, $this->getWebPageTypeChildren($edge->getVertexEnd()));
        }

        return $types;
    }

    protected function createListOfAvailableTypes(Vertex $rootType): void
    {
        $types = $this->collectAvailableTypes($rootType);

        $types = \array_unique($types);
        \sort($types);

        $providerClass = $this->twig->render(
            'TypeModels.php.twig',
            [
                'types' => $types,
            ]
        );

        \file_put_contents($this->configuration->typeModelsTemplate, $providerClass);
    }

    protected function collectAvailableTypes(Vertex $type): array
    {
        $types = [$type->getAttribute(static::ATTRIBUTE_LABEL)];
        foreach ($type->getEdgesOut() as $edge) {
            $types = array_merge($types, $this->collectAvailableTypes($edge->getVertexEnd()));
        }

        return $types;
    }

    protected function identifyWebPageElementTypes(): void
    {
        $this->webPageElementTypes = $this->getWebPageElementTypeChildren($this->types[static::ROOT_WEBPAGEELEMENT_TYPE_ID]);
        \sort($this->webPageElementTypes);
    }

    protected function getWebPageElementTypeChildren(Vertex $type): array
    {
        $types = [$type->getAttribute(static::ATTRIBUTE_LABEL)];

        /** @var Directed $edge */
        foreach ($type->getEdgesOut() as $edge) {
            $types = \array_merge($types, $this->getWebPageElementTypeChildren($edge->getVertexEnd()));
        }

        return $types;
    }
}
