<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\TypoScript;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;
use DomainException;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Convert any given TypoScript to proper schema types.
 * The result will be added as single (nested) type to the SchemaManager.
 */
class TypoScriptToSchema
{
    private SchemaManager $schemaManager;

    private Logger $logger;

    private ContentObjectRenderer $cObj;

    public function __construct(
        SchemaManager $schemaManager,
        LogManager $logManager
    ) {
        $this->schemaManager = $schemaManager;
        $this->logger = $logManager->getLogger(__CLASS__);
    }

    /**
     * @param mixed[] $configuration
     */
    public function convert(
        ContentObjectRenderer $cObj,
        array $configuration
    ): void {
        $this->cObj = $cObj;

        $type = $this->buildType($configuration);
        if ($type instanceof TypeInterface) {
            $this->schemaManager->addType($type);
        }
    }

    /**
     * @param mixed[] $configuration
     */
    private function buildType(array $configuration): ?TypeInterface
    {
        if ($this->hasFalsyIf($configuration)) {
            return null;
        }
        unset($configuration['if.']);

        $configuredType = $this->cObj->stdWrapValue('type', $configuration);
        try {
            $type = TypeFactory::createType($configuredType);
        } catch (DomainException $e) {
            // Do not break production sites, catch exception and return nothing.
            $this->logger->error('Tried to create unkown Schema type "' . $configuredType . '".');
            return null;
        }

        $type->setId($this->cObj->stdWrapValue('id', $configuration));
        $this->addProperties($type, $configuration['properties.'] ?? []);

        return $type;
    }

    /**
     * @param mixed[] $properties
     */
    private function addProperties(TypeInterface $type, array $properties): void
    {
        foreach (array_keys($properties) as $name) {
            $propertyName = rtrim($name, '.');

            try {
                $this->addProperty($type, $propertyName, $name, $properties);
            } catch (DomainException $e) {
                $this->logger->error('Tried to set unkown property "' . $propertyName . '".');
                continue;
            }
        }
    }

    /**
     * @param mixed[] $properties
     */
    private function addProperty(
        TypeInterface $type,
        string $propertyName,
        string $name,
        array $properties
    ): void {
        if ($this->isFullType($name, $properties)) {
            $type->setProperty(
                $propertyName,
                $this->buildType($properties[$name . '.'])
            );
            return;
        }

        if ($this->isIdOnly($name, $properties)) {
            $type->setProperty(
                $propertyName,
                [
                    'id' => $this->cObj->stdWrapValue('id', $properties[$name . '.']),
                ],
            );
            return;
        }

        if ($this->hasCObjectDefinition($propertyName, $properties)) {
            return;
        }

        $type->setProperty(
            $propertyName,
            $this->cObj->stdWrapValue($propertyName, $properties)
        );
    }

    /**
     * @param mixed[] $properties
     */
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

    /**
     * @param mixed[] $properties
     */
    private function isIdOnly(string $name, array $properties): bool
    {
        $configuration = $properties[$name . '.'] ?? [];

        $hasId = isset($configuration['id']) || isset($configuration['id.']);
        $hasFurtherProperties = array_diff(array_keys($configuration), ['id', 'id.']) !== [];

        return isset($properties[$name]) && $properties[$name] === 'SCHEMA'
            && $hasId
            && ! $hasFurtherProperties
            ;
    }

    /**
     * @param mixed[] $configuration
     */
    private function hasFalsyIf(array $configuration): bool
    {
        return isset($configuration['if.'])
            && ! $this->cObj->checkIf($configuration['if.'])
            ;
    }

    /**
     * @param mixed[] $properties
     */
    private function hasCObjectDefinition(string $name, array $properties): bool
    {
        return ($properties[$name] ?? '') !== ''
            && isset($properties[$name . '.']);
    }
}
