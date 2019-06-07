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
    protected $id = null;

    /**
     * @var array
     */
    protected $properties = [];

    public function __construct()
    {
        // use method addProperties() to add schema properties
        // and don't forget to call the parent constructor
    }

    /**
     * Add the property names for the specific type
     *
     * @param string ...$propertyNames The property names of the specific type
     */
    protected function addProperties(string ...$propertyNames): void
    {
        $this->properties += array_fill_keys($propertyNames, null);
    }

    /**
     * Get the id (special property @id)
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the id (special property @id)
     *
     * @param string $id The id
     * @return AbstractType
     */
    public function setId(string $id): self
    {
        $this->id = $id;

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
        return \array_key_exists($propertyName, $this->properties);
    }

    /**
     * Get the value of a property
     *
     * @param string $propertyName The property name
     * @return string|array|AbstractType
     */
    public function getProperty(string $propertyName)
    {
        if (!\array_key_exists($propertyName, $this->properties)) {
            throw new \DomainException(
                sprintf('Property name "%s" is unknown for schema type "%s"', $propertyName, $this->getType())
            );
        }

        return $this->properties[$propertyName];
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
        $this->checkProperty($propertyName, $propertyValue);

        $this->properties[$propertyName] = $propertyValue;

        return $this;
    }

    /**
     * Check, if property name and value are valid
     *
     * @param string $propertyName The property name
     * @param string|array|AbstractType $propertyValue The property value
     *
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    protected function checkProperty(string $propertyName, $propertyValue): void
    {
        if (!\array_key_exists($propertyName, $this->properties)) {
            throw new \DomainException(
                \sprintf('Property name "%s" is unknown for schema type "%s"', $propertyName, $this->getType())
            );
        }

        if (!\is_string($propertyValue) && !\is_array($propertyValue) && !$propertyValue instanceof AbstractType) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Given value for property name %s has not a valid data type. Valid types are: string, array, instanceof AbstractType',
                    $propertyName
                )
            );
        }
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
        $this->checkProperty($propertyName, $propertyValue);

        if (\is_null($this->properties[$propertyName])) {
            $this->properties[$propertyName] = $propertyValue;

            return $this;
        }

        if (\is_string($this->properties[$propertyName]) || $this->properties[$propertyName] instanceof AbstractType) {
            $this->properties[$propertyName] = [
                $this->properties[$propertyName],
                $propertyValue,
            ];

            return $this;
        }

        $this->properties[$propertyName] = [
            $this->properties[$propertyName],
            $propertyValue,
        ];

        return $this;
    }

    /**
     * Get the type
     *
     * @return string
     */
    protected function getType(): string
    {
        $tokenizedClassName = \explode('\\', static::class);

        return \array_pop($tokenizedClassName);
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

        if ($this->id) {
            $result['@id'] = $this->id;
        }

        foreach ($this->properties as $propertyName => $propertyValue) {
            if (empty($propertyValue)) {
                continue;
            }

            if ($propertyValue instanceof AbstractType) {
                $result[$propertyName] = $propertyValue->toArray(false);

                continue;
            }

            if (\is_array($propertyValue)) {
                $result[$propertyName] = [];

                foreach ($propertyValue as $singlePropertyValue) {
                    if (\is_string($singlePropertyValue)) {
                        $result[$propertyName][] = $singlePropertyValue;
                    } else {
                        $result[$propertyName][] = $singlePropertyValue->toArray(false);
                    }
                }

                continue;
            }

            $result[$propertyName] = $propertyValue;
        }

        if (empty($result)) {
            return [];
        }

        $header = [];

        if ($isRoot) {
            $header['@context'] = self::CONTEXT;
        }

        $header['@type'] = $this->getType();

        return \array_merge($header, $result);
    }
}
