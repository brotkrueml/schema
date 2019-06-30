<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\Model;

use Brotkrueml\Schema\Utility\Utility;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
abstract class AbstractType
{
    protected const CONTEXT = 'http://schema.org';

    /**
     * @var string|null
     */
    protected $_id = null;

    /**
     * Get the id (special property @id)
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->_id;
    }

    /**
     * Set the id (special property @id)
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
     * @param string $property The property name
     * @return bool
     */
    public function hasProperty(string $property): bool
    {
        return \property_exists($this, $property);
    }

    /**
     * Get the value of a property
     *
     * @param string $property The property name
     * @return string|array|AbstractType
     */
    public function getProperty(string $property)
    {
        if (!\property_exists($this, $property)) {
            throw new \DomainException(
                sprintf('Property "%s" is unknown for type "%s"', $property, $this->getType()),
                1561829996
            );
        }

        return $this->$property;
    }

    /**
     * Set the value of a property
     *
     * @param string $property The property name
     * @param string|array|AbstractType $value The value of the property
     * @return AbstractType
     */
    public function setProperty(string $property, $value): self
    {
        $this->checkProperty($property, $value);

        if (\is_int($value)) {
            $value = (string)$value;
        }

        $this->$property = $value;

        return $this;
    }

    /**
     * Check, if property name and value are valid
     *
     * @param string $property The property name
     * @param string|array|AbstractType $value The property value
     *
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    protected function checkProperty(string $property, $value): void
    {
        if (!\property_exists($this, $property)) {
            throw new \DomainException(
                sprintf('Property "%s" is unknown for type "%s"', $property, $this->getType()),
                1561829996
            );
        }

        if (!(\is_string($value) || \is_int($value) || \is_array($value) || $value instanceof AbstractType)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Value for property "%s" has not a valid data type (given: "%s"). Valid types are: string, int, array, instanceof AbstractType',
                    $property,
                    \is_object($value) ? \get_class($value) : \gettype($value)
                ),
                1561830012
            );
        }
    }

    /**
     * Adds a value to a property
     *
     * @param string $property The property name
     * @param string|array|AbstractType $value The property value
     * @return AbstractType
     */
    public function addProperty(string $property, $value): self
    {
        $this->checkProperty($property, $value);

        if (\is_null($this->$property)) {
            $this->$property = $value;

            return $this;
        }

        if (\is_array($this->$property)) {
            if (\is_string($value) || $value instanceof AbstractType) {
                $value = [$value];
            }

            $this->$property = \array_merge($this->$property, $value);

            return $this;
        }

        $this->$property = [
            $this->$property,
            $value,
        ];

        return $this;
    }

    /**
     * Clear a property (set it to null)
     *
     * @param string $property The property name
     *
     * @return AbstractType
     */
    public function clearProperty(string $property): self
    {
        $this->$property = null;

        return $this;
    }

    /**
     * Get the available properties
     *
     * @return array
     */
    public function getProperties(): array
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
     * Get the type
     *
     * @return string
     */
    protected function getType(): string
    {
        return Utility::getClassNameWithoutNamespace(static::class);
    }

    /**
     * Generate an array representation of the type
     *
     * @param bool $isRootType Is the root type?
     * @return array
     */
    public function toArray(bool $isRootType = true): array
    {
        $result = [];

        if ($this->_id) {
            $result['@id'] = $this->_id;
        }

        foreach ($this->getProperties() as $property) {
            if (\is_null($this->$property)) {
                continue;
            }

            if ($this->$property instanceof AbstractType) {
                $result[$property] = $this->$property->toArray(false);

                continue;
            }

            if (\is_array($this->$property)) {
                $result[$property] = [];

                /** @var AbstractType|string $singleValue */
                foreach ($this->$property as $singleValue) {
                    if (\is_string($singleValue)) {
                        $result[$property][] = $singleValue;
                    } else {
                        $result[$property][] = $singleValue->toArray(false);
                    }
                }

                continue;
            }

            $result[$property] = $this->$property;
        }

        if (empty($result)) {
            return [];
        }

        $header = [];

        if ($isRootType) {
            $header['@context'] = static::CONTEXT;
        }

        $header['@type'] = $this->getType();

        return \array_merge($header, $result);
    }
}
