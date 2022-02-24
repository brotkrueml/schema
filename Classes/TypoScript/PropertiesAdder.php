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
use DomainException;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Adds properties defined bu TypoScript configuration to given Type.
 */
class PropertiesAdder
{
    private TypeBuilder $typeBuilder;

    private Logger $logger;

    private ContentObjectRenderer $cObj;

    public function __construct(
        TypeBuilder $typeBuilder,
        LogManager $logManager
    ) {
        $this->typeBuilder = $typeBuilder;
        $this->logger = $logManager->getLogger(self::class);
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
            $subType = $this->typeBuilder->build(
                $this->cObj,
                $properties[$name . '.']
            );
            if ($subType instanceof TypeInterface) {
                $this->add($this->cObj, $subType, $properties[$name . '.']['properties.'] ?? []);
                $type->setProperty($propertyName, $subType);
            }
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
     * @param mixed[] $properties
     */
    private function hasCObjectDefinition(string $name, array $properties): bool
    {
        return ($properties[$name] ?? '') !== ''
            && isset($properties[$name . '.']);
    }
}
