<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

use Brotkrueml\Schema\Core\Exception\InvalidPropertyValueException;
use Brotkrueml\Schema\Core\Exception\UnknownPropertyException;

/**
 * This class provides the logic for both, a single type and a multiple type.
 * It is not for use in custom extensions. Use AbstractType instead.
 *
 * @internal
 */
abstract class AbstractBaseType implements TypeInterface
{
    /**
     * The ID of the type (mapped to @id in result)
     */
    private ?NodeIdentifierInterface $id = null;

    /**
     * The properties of a specific type with their corresponding value:
     * <propertyName> => <propertyValue>
     * Also the additional properties added by an event listener are included
     *
     * @var array<string, mixed>
     * @internal
     */
    protected array $properties = [];

    public function setId(NodeIdentifierInterface|string|null $id): static
    {
        if ($id === '') {
            $id = null;
        }

        if (\is_string($id)) {
            $id = new NodeIdentifier($id);
        }

        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id instanceof NodeIdentifierInterface ? $this->id->getId() : null;
    }

    public function hasProperty(string $propertyName): bool
    {
        try {
            $this->checkPropertyExists($propertyName);
        } catch (\DomainException) {
            return false;
        }

        return true;
    }

    public function getProperty(string $propertyName): mixed
    {
        $this->checkPropertyExists($propertyName);

        return $this->properties[$propertyName];
    }

    private function checkPropertyExists(string $propertyName): void
    {
        if (! \array_key_exists($propertyName, $this->properties)) {
            throw UnknownPropertyException::fromPropertyName($this->getType(), $propertyName);
        }
    }

    public function setProperty(string $propertyName, mixed $propertyValue): static
    {
        $propertyValue = $this->stringifyNumericValue($propertyValue);
        $this->checkProperty($propertyName, $propertyValue);

        $this->properties[$propertyName] = $propertyValue;

        return $this;
    }

    /**
     * If the value is a numeric one, stringify it
     *
     * @return string|mixed
     */
    private function stringifyNumericValue(mixed $value)
    {
        return \is_numeric($value) ? (string) $value : $value;
    }

    /**
     * Check, if property name and value are valid
     *
     * @param string $propertyName The property name
     * @param mixed $propertyValue The property value
     *
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    private function checkProperty(string $propertyName, mixed $propertyValue): void
    {
        $this->checkPropertyExists($propertyName);

        if (! $this->isValidDataTypeForPropertyValue($propertyValue)) {
            throw InvalidPropertyValueException::fromValueType($propertyName, \get_debug_type($propertyValue));
        }
    }

    /**
     * Returns true, if data type of property value is allowed
     */
    private function isValidDataTypeForPropertyValue(mixed $propertyValue): bool
    {
        return $propertyValue === null
            || \is_string($propertyValue)
            || \is_array($propertyValue)
            || \is_bool($propertyValue)
            || $propertyValue instanceof NodeIdentifierInterface
            || $propertyValue instanceof TypeInterface
            || $propertyValue instanceof EnumerationInterface;
    }

    public function addProperty(string $propertyName, mixed $propertyValue): static
    {
        $propertyValue = $this->stringifyNumericValue($propertyValue);
        $this->checkProperty($propertyName, $propertyValue);

        if ($this->properties[$propertyName] === null) {
            $this->properties[$propertyName] = $propertyValue;

            return $this;
        }

        if (\is_array($this->properties[$propertyName])) {
            if (! \is_array($propertyValue)) {
                $propertyValue = [$propertyValue];
            }

            $this->properties[$propertyName] = \array_merge($this->properties[$propertyName], $propertyValue);

            return $this;
        }

        $this->properties[$propertyName] = [
            $this->properties[$propertyName],
            $propertyValue,
        ];

        return $this;
    }

    public function setProperties(array $properties): static
    {
        foreach ($properties as $propertyName => $propertyValue) {
            $this->setProperty($propertyName, $propertyValue);
        }

        return $this;
    }

    public function clearProperty(string $propertyName): static
    {
        $this->checkPropertyExists($propertyName);

        $this->properties[$propertyName] = null;

        return $this;
    }

    public function getPropertyNames(): array
    {
        return \array_keys($this->properties);
    }
}
