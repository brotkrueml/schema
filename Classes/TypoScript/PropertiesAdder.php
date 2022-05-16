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
    private TypoScriptConverter $typoScriptConverter;
    private ContentObjectRenderer $cObj;

    public function __construct(
        TypeBuilder $typeBuilder,
        TypoScriptConverter $typoScriptConverter
    ) {
        $this->typeBuilder = $typeBuilder;
        $this->typoScriptConverter = $typoScriptConverter;
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

        $properties = $this->typoScriptConverter->convertTypoScriptArrayToPlainArray($properties);
        foreach (\array_keys($properties) as $name) {
            try {
                $this->addProperty($type, $name, $properties);
            } catch (DomainException $e) {
                $this->logger->error(\sprintf(
                    'Use of unknown property "%s" for type "%s"',
                    $name,
                    $type->getType() // @phpstan-ignore-line It can only be a string (no array) as the cObject does not support multiple types
                ));
                continue;
            }
        }
    }

    /**
     * @param mixed[] $properties
     */
    private function addProperty(TypeInterface $type, string $name, array $properties): void
    {
        if (\is_string($properties[$name])) {
            $type->setProperty($name, $properties[$name]);
            return;
        }

        if ($this->isIdOnly($properties[$name])) {
            $this->addIdOnly($name, $properties[$name], $type);
            return;
        }

        if ($this->isFullType($properties[$name])) {
            $this->addFullType($name, $properties[$name], $type);
            return;
        }

        $type->setProperty($name, $this->cObj->stdWrapValue($name, $this->typoScriptConverter->convertPlainArrayToTypoScriptArray($properties)));
    }

    /**
     * @param mixed[] $configuration
     */
    private function addIdOnly(string $name, array $configuration, TypeInterface $type): void
    {
        if (\is_string($configuration['id'])) {
            $id = $configuration['id'];
        } else {
            $id = (string)$this->cObj->stdWrapValue(
                'id',
                $this->typoScriptConverter->convertPlainArrayToTypoScriptArray($configuration)
            );
        }

        if ($id === '') {
            return;
        }

        $type->setProperty($name, new NodeIdentifier($id));
    }

    /**
     * @param mixed[] $configuration
     */
    private function addFullType(string $name, array $configuration, TypeInterface $type): void
    {
        $subType = $this->typeBuilder->build(
            $this->cObj,
            $this->typoScriptConverter->convertPlainArrayToTypoScriptArray($configuration)
        );
        if (! $subType instanceof TypeInterface) {
            return;
        }

        $this->add($this->cObj, $subType, $configuration['properties'] ?? []);
        $type->setProperty($name, $subType);
    }

    /**
     * @param mixed[] $configuration
     */
    private function isFullType(array $configuration): bool
    {
        return ($configuration['_typoScriptNodeValue'] ?? '') === 'SCHEMA'
            && ($configuration['type'] ?? '') !== '';
    }

    /**
     * @param mixed[] $configuration
     */
    private function isIdOnly(array $configuration): bool
    {
        return ($configuration['_typoScriptNodeValue'] ?? '') === 'SCHEMA'
            && isset($configuration['id'])
            && \count($configuration) === 2;
    }
}
