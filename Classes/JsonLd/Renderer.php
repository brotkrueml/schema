<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\JsonLd;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;
use Brotkrueml\Schema\Core\Model\NodeIdentifierInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Model\DataType\Boolean;

/**
 * @internal
 */
final class Renderer implements RendererInterface
{
    private const CONTEXT = 'https://schema.org/';

    /**
     * @var TypeInterface[]
     */
    private array $types = [];

    /**
     * @var array<string,mixed>
     */
    private array $typeResult = [];

    public function addType(TypeInterface ...$type): void
    {
        $this->types = \array_merge($this->types, $type);
    }

    public function clearTypes(): void
    {
        $this->types = [];
    }

    public function render(): string
    {
        $renderedTypes = [];
        foreach ($this->types as $type) {
            $renderedTypes[] = $this->prepare($type);
        }

        if ($renderedTypes === []) {
            return '';
        }

        $result = \count($renderedTypes) === 1 ? $renderedTypes[0] : [
            '@graph' => $renderedTypes,
        ];

        $result = \array_merge([
            '@context' => self::CONTEXT,
        ], $result);

        return \json_encode($result, \JSON_HEX_TAG | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR);
    }

    /**
     * @return mixed[][]|bool[]|float[]|int[]|string[]
     */
    private function prepare(TypeInterface $type): array
    {
        $this->typeResult = [];

        $this->addTypeToResult($type);
        $this->addIdToResult($type);
        $this->addPropertiesToResult($type);

        return $this->typeResult;
    }

    private function addTypeToResult(TypeInterface $type): void
    {
        $this->typeResult['@type'] = $type->getType();
    }

    private function addIdToResult(TypeInterface $type): void
    {
        $id = $type->getId() ?? '';
        if ($id !== '') {
            $this->typeResult['@id'] = $id;
        }
    }

    private function addPropertiesToResult(TypeInterface $type): void
    {
        foreach ($type->getPropertyNames() as $propertyName) {
            $propertyValue = $type->getProperty($propertyName);
            if ($propertyValue === null) {
                continue;
            }
            if ($propertyValue === '') {
                continue;
            }
            if ($propertyValue === []) {
                continue;
            }

            if (\is_array($propertyValue)) {
                $this->typeResult[$propertyName] = [];
                foreach ($propertyValue as $singlePropertyValue) {
                    $this->typeResult[$propertyName][] = $this->getPropertyValueForResult($singlePropertyValue);
                }
                continue;
            }

            $this->typeResult[$propertyName] = $this->getPropertyValueForResult($propertyValue);
        }
    }

    /**
     * @return array<string, mixed>|string
     */
    private function getPropertyValueForResult(NodeIdentifierInterface|TypeInterface|EnumerationInterface|bool|string|int|float $value): array|string
    {
        if ($value instanceof TypeInterface) {
            return (new self())->prepare($value);
        }

        if ($value instanceof NodeIdentifierInterface) {
            return [
                '@id' => $value->getId(),
            ];
        }

        if ($value instanceof EnumerationInterface) {
            return $value->canonical();
        }

        if (\is_bool($value)) {
            return Boolean::convertToTerm($value);
        }

        if (\is_numeric($value)) {
            return (string) $value;
        }

        return $value;
    }
}
