<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Core\Model;

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
                sprintf('Property "%s" is unknown for type "%s"', $property, $this->getType())
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
                sprintf('Property "%s" is unknown for type "%s"', $property, $this->getType())
            );
        }

        if (!\is_string($value) && !\is_array($value) && !$value instanceof AbstractType) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Given value for property "%s" has not a valid data type. Valid types are: string, array, instanceof AbstractType',
                    $property
                )
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

        $this->$property = [
            $this->$property,
            $value,
        ];

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
        $tokenisedClassName = \explode('\\', static::class);

        return \end($tokenisedClassName);
    }

    /**
     * Generate an array representation of the type
     *
     * @param bool $isRoot Is the root type?
     * @return array
     */
    public function toArray(bool $isRoot = true): array
    {
        $result = [];

        if ($this->_id) {
            $result['@id'] = $this->_id;
        }

        foreach (\get_object_vars($this) as $property => $value) {
            if (\substr($property, 0, 1) === '_') {
                continue;
            }

            if (empty($value)) {
                continue;
            }

            if ($value instanceof AbstractType) {
                $result[$property] = $value->toArray(false);

                continue;
            }

            if (\is_array($value)) {
                $result[$property] = [];

                foreach ($value as $singleValue) {
                    if (\is_string($singleValue)) {
                        $result[$property][] = $singleValue;
                    } else {
                        $result[$property][] = $singleValue->toArray(false);
                    }
                }

                continue;
            }

            $result[$property] = $value;
        }

        if (empty($result)) {
            return [];
        }

        $header = [];

        if ($isRoot) {
            $header['@context'] = static::CONTEXT;
        }

        $header['@type'] = $this->getType();

        return \array_merge($header, $result);
    }
}
