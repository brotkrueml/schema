<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

interface TypeInterface
{
    /**
     * Get the id
     *
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * Set the id
     *
     * @param string $id The id
     * @return self
     */
    public function setId(string $id);

    /**
     * Check, if a property exists
     *
     * @param string $propertyName The property name
     * @return bool
     */
    public function hasProperty(string $propertyName): bool;

    /**
     * Get the value of a property
     *
     * @param string $propertyName The property name
     * @return mixed
     */
    public function getProperty(string $propertyName);

    /**
     * Set the value of a property
     *
     * @param string $propertyName The property name
     * @param mixed $propertyValue The value of the property
     * @return self
     */
    public function setProperty(string $propertyName, $propertyValue);

    /**
     * Adds a value to a property
     *
     * @param string $propertyName The property name
     * @param mixed $propertyValue The property value
     * @return self
     */
    public function addProperty(string $propertyName, $propertyValue);

    /**
     * Set multiple properties at once
     *
     * The method expects the properties in the following format:
     * key = property name
     * value = property value
     *
     * @param array<string, mixed> $properties
     * @return self
     */
    public function setProperties(array $properties);

    /**
     * Clear a property
     *
     * @param string $propertyName The property name
     * @return self
     */
    public function clearProperty(string $propertyName);

    /**
     * Get the available property names
     *
     * @return array<string>
     */
    public function getPropertyNames(): array;

    /**
     * Get the type the model represents
     *
     * @return string
     */
    public function getType(): string;
}
