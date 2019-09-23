<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\Model;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Utility\Utility;

abstract class AbstractType
{
    /**
     * The ID of the type (mapped to @id in result)
     *
     * @var string|null
     */
    private $_id;

    /**
     * The fully rendered type with all children as array
     *
     * @var array
     */
    private $__resultArray = [];

    /**
     * Get the id
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->_id;
    }

    /**
     * Set the id
     *
     * @param string $id The id
     * @return AbstractType
     */
    public function setId(string $id): self
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * Check, if a property exists
     *
     * @param string $propertyName The property name
     * @return bool
     */
    public function hasProperty(string $propertyName): bool
    {
        return \property_exists($this, $propertyName);
    }

    /**
     * Get the value of a property
     *
     * @param string $propertyName The property name
     * @return string|array|AbstractType
     */
    public function getProperty(string $propertyName)
    {
        $this->checkPropertyExists($propertyName);

        return $this->$propertyName;
    }

    private function checkPropertyExists(string $propertyName): void
    {
        if (!\property_exists($this, $propertyName)) {
            throw new \DomainException(
                sprintf('Property "%s" is unknown for type "%s"', $propertyName, $this->getType()),
                1561829996
            );
        }
    }

    /**
     * Set the value of a property
     *
     * @param string $propertyName The property name
     * @param string|array|AbstractType $propertyValue The value of the property
     * @return AbstractType
     */
    public function setProperty(string $propertyName, $propertyValue): self
    {
        $propertyValue = $this->stringifyNumericValue($propertyValue);
        $this->checkProperty($propertyName, $propertyValue);

        $this->$propertyName = $propertyValue;

        return $this;
    }

    /**
     * If the value is a numeric one, stringify it
     *
     * @param mixed $value
     * @return string|AbstractType
     */
    private function stringifyNumericValue($value)
    {
        return \is_numeric($value) ? (string)$value : $value;
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
    private function checkProperty(string $propertyName, $propertyValue): void
    {
        $this->checkPropertyExists($propertyName);

        if (!$this->isValidDataTypeForPropertyValue($propertyValue)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Value for property "%s" has not a valid data type (given: "%s"). Valid types are: null, string, int, array, instanceof AbstractType',
                    $propertyName,
                    \is_object($propertyValue) ? \get_class($propertyValue) : \gettype($propertyValue)
                ),
                1561830012
            );
        }
    }

    /**
     * Returns true, if data type of property value is allowed
     *
     * @param mixed $propertyValue
     * @return bool
     */
    private function isValidDataTypeForPropertyValue($propertyValue): bool
    {
        return $propertyValue === null
            || \is_string($propertyValue)
            || \is_array($propertyValue)
            || $propertyValue instanceof AbstractType;
    }

    /**
     * Adds a value to a property
     *
     * @param string $propertyName The property name
     * @param string|array|AbstractType $propertyValue The property value
     * @return AbstractType
     */
    public function addProperty(string $propertyName, $propertyValue): self
    {
        $propertyValue = $this->stringifyNumericValue($propertyValue);
        $this->checkProperty($propertyName, $propertyValue);

        if ($this->$propertyName === null) {
            $this->$propertyName = $propertyValue;

            return $this;
        }

        if (\is_array($this->$propertyName)) {
            if (\is_string($propertyValue) || $propertyValue instanceof AbstractType) {
                $propertyValue = [$propertyValue];
            }

            $this->$propertyName = \array_merge($this->$propertyName, $propertyValue);

            return $this;
        }

        $this->$propertyName = [
            $this->$propertyName,
            $propertyValue,
        ];

        return $this;
    }

    /**
     * Set multiple properties at once
     *
     * The method expects the properties in the following format:
     * key = property name
     * value = property value
     *
     * @param array $properties
     * @return AbstractType
     */
    public function setProperties(array $properties): self
    {
        foreach ($properties as $propertyName => $propertyValue) {
            $this->setProperty($propertyName, $propertyValue);
        }

        return $this;
    }

    /**
     * Clear a property (set it to null)
     *
     * @param string $propertyName The property name
     *
     * @return AbstractType
     */
    public function clearProperty(string $propertyName): self
    {
        $this->checkPropertyExists($propertyName);

        $this->$propertyName = null;

        return $this;
    }

    /**
     * Get the available properties names
     *
     * @return array
     */
    public function getPropertyNames(): array
    {
        $properties = \array_keys(
            \array_filter(
                \get_object_vars($this),
                function ($property) {
                    return \substr($property, 0, 1) !== '_';
                },
                ARRAY_FILTER_USE_KEY
            )
        );

        \sort($properties);

        return $properties;
    }

    /**
     * Check if all properties are not set with a value
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        $propertiesNotEmpty = \array_filter($this->getPropertyNames(), function ($property) {
            return !empty($this->$property);
        });

        return empty($propertiesNotEmpty);
    }

    private function getType(): string
    {
        return Utility::getClassNameWithoutNamespace(static::class);
    }

    /**
     * Generate an array representation of the type
     *
     * @return array
     * @internal
     */
    public function toArray(): array
    {
        $this->__resultArray = [];

        $this->addTypeToResultArray();
        $this->addIdToResultArray();
        $this->addPropertiesToResultArray();

        return $this->__resultArray;
    }

    private function addTypeToResultArray(): void
    {
        $this->__resultArray['@type'] = $this->getType();
    }

    private function addIdToResultArray(): void
    {
        if ($this->_id) {
            $this->__resultArray['@id'] = $this->_id;
        }
    }

    private function addPropertiesToResultArray(): void
    {
        foreach ($this->getPropertyNames() as $property) {
            if ($this->$property === null || $this->$property === '') {
                continue;
            }

            if ($this->$property instanceof AbstractType) {
                $this->__resultArray[$property] = $this->$property->toArray();

                continue;
            }

            if (\is_array($this->$property)) {
                $this->__resultArray[$property] = [];

                /** @var AbstractType|string $singleValue */
                foreach ($this->$property as $singleValue) {
                    $this->__resultArray[$property][] =
                        \is_string($singleValue)
                            ? $singleValue
                            : $singleValue->toArray();
                }

                continue;
            }

            $this->__resultArray[$property] = $this->$property;
        }
    }
}
