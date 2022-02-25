<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\TypoScript;

use Brotkrueml\Schema\Core\Model\NodeIdentifier;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use DomainException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Adds properties defined by TypoScript configuration to given type.
 * @internal
 */
final class PropertiesAdder implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private TypeBuilder $typeBuilder;
    private ContentObjectRenderer $cObj;

    public function __construct(
        TypeBuilder $typeBuilder
    ) {
        $this->typeBuilder = $typeBuilder;
    }

    /**
     * @param mixed[] $properties
     */
    public function add(
        ContentObjectRenderer $cObj,
        TypeInterface $type,
        array $properties
    ): void {
        $this->cObj = $cObj;

        foreach (array_keys($properties) as $name) {
            try {
                $this->addProperty($type, $name, $properties);
            } catch (DomainException $e) {
                $this->logger->error('Tried to set unknown property "' . $this->getPropertyNameFromName($name) . '".');
                continue;
            }
        }
    }

    /**
     * @param mixed[] $properties
     */
    private function addProperty(
        TypeInterface $type,
        string $name,
        array $properties
    ): void {
        $propertyName = $this->getPropertyNameFromName($name);

        if ($this->isIdOnly($name, $properties)) {
            $this->addIdOnly($name, $properties, $type);
            return;
        }

        if ($this->isFullType($name, $properties)) {
            $this->addFullType($name, $properties, $type);
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
    private function addIdOnly(
        string $name,
        array $properties,
        TypeInterface $type
    ): void {
        $id = (string)$this->cObj->stdWrapValue('id', $properties[$name . '.']);

        if ($id === '') {
            return;
        }

        $type->setProperty(
            $this->getPropertyNameFromName($name),
            new NodeIdentifier($id)
        );
    }

    /**
     * @param mixed[] $properties
     */
    private function addFullType(
        string $name,
        array $properties,
        TypeInterface $type
    ): void {
        $subType = $this->typeBuilder->build(
            $this->cObj,
            $properties[$name . '.']
        );
        if (! $subType instanceof TypeInterface) {
            return;
        }

        $this->add($this->cObj, $subType, $properties[$name . '.']['properties.'] ?? []);
        $type->setProperty(
            $this->getPropertyNameFromName($name),
            $subType
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
     * @param mixed[] $properties
     */
    private function hasCObjectDefinition(string $name, array $properties): bool
    {
        return ($properties[$name] ?? '') !== ''
            && isset($properties[$name . '.']);
    }

    private function getPropertyNameFromName(string $name): string
    {
        return rtrim($name, '.');
    }
}
