<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Frontend;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;
use DomainException;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Convert any given TypoScript to proper schema types.
 * The result will be added as single (nested) type to the SchemaManager.
 */
class TypoScriptToSchema
{
    private SchemaManager $schemaManager;

    private ContentObjectRenderer $cObj;

    public function __construct(
        SchemaManager $schemaManager
    ) {
        $this->schemaManager = $schemaManager;
    }

    public function convert(
        ContentObjectRenderer $cObj,
        array $configuration
    ): void {
        $this->cObj = $cObj;

        $type = $this->getType($configuration);
        if ($type instanceof TypeInterface) {
            $this->schemaManager->addType($type);
        }
    }

    private function getType(array $configuration): ?TypeInterface
    {
        if ($this->hasFalsyIf($configuration)) {
            return null;
        }
        unset($configuration['if.']);

        try {
            $type = TypeFactory::createType($this->cObj->stdWrapValue('type', $configuration, ''));
        } catch (DomainException $e) {
            // Do not break production sites, catch exception and return nothing.
            return null;
        }

        $type->setId($this->cObj->stdWrapValue('id', $configuration, ''));
        $this->addProperties($type, $configuration['properties.'] ?? []);

        return $type;
    }

    private function addProperties(TypeInterface $type, array $properties): void
    {
        foreach ($properties as $name => $configuration) {
            $propertyName = rtrim($name, '.');

            if ($this->isFullType($name, $properties)) {
                $type->setProperty(
                    $propertyName,
                    $this->getType($properties[$name . '.'])
                );
                continue;
            }

            if ($this->isIdOnly($name, $properties)) {
                $type->setProperty(
                    $propertyName,
                    [
                        'id' => $this->cObj->stdWrapValue('id', $properties[$name . '.']),
                    ],
                );
                continue;
            }

            if ($this->hasCObjectDefinition($propertyName, $properties)) {
                continue;
            }

            $type->setProperty(
                $propertyName,
                $this->cObj->stdWrapValue($propertyName, $properties)
            );
        }
    }

    private function isFullType(string $name, array $properties): bool
    {
        return isset($properties[$name]) && $properties[$name] === 'SCHEMA'
            && isset($properties[$name . '.'])
            && (
                isset($properties[$name . '.']['type'])
                || isset($properties[$name . '.']['type.'])
            )
            ;
    }

    private function isIdOnly(string $name, array $properties): bool
    {
        $configuration = $properties[$name . '.'] ?? [];

        $hasId = isset($configuration['id']) || isset($configuration['id.']);
        $hasFurtherProperties = array_diff(array_keys($configuration), ['id', 'id.']) !== [];

        return isset($properties[$name]) && $properties[$name] === 'SCHEMA'
            && $hasId
            && $hasFurtherProperties === false
            ;
    }

    private function hasFalsyIf(array $configuration): bool
    {
        return isset($configuration['if.'])
            && $this->cObj->checkIf($configuration['if.']) === false
            ;
    }

    private function hasCObjectDefinition(string $name, array $properties): bool
    {
        return ($properties[$name] ?? '') !== ''
            && isset($properties[$name . '.']);
    }
}
