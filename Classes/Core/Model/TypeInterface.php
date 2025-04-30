<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

interface TypeInterface extends NodeIdentifierInterface
{
    /**
     * Set the id.
     */
    public function setId(NodeIdentifierInterface|string|null $id): static;

    /**
     * Check, if a property exists.
     */
    public function hasProperty(string $propertyName): bool;

    /**
     * Get the value of a property.
     */
    public function getProperty(string $propertyName): mixed;

    /**
     * Set the value of a property.
     */
    public function setProperty(string $propertyName, mixed $propertyValue): static;

    /**
     * Adds a value to a property.
     */
    public function addProperty(string $propertyName, mixed $propertyValue): static;

    /**
     * Set multiple properties at once.
     *
     * The method expects the properties in the following format:
     * key = property name
     * value = property value
     *
     * @param array<string, mixed> $properties
     */
    public function setProperties(array $properties): static;

    /**
     * Clear a property.
     */
    public function clearProperty(string $propertyName): static;

    /**
     * Get the available property names.
     *
     * @return list<string>
     */
    public function getPropertyNames(): array;

    /**
     * Get the type the model represents.
     * This can also be an array of types for a multiple type.
     *
     * @return string|string[]
     */
    public function getType(): string|array;
}
