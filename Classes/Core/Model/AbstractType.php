<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Extension;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractType implements TypeInterface
{
    /**
     * The properties of a specific type
     * These are defined in the concrete type model class
     *
     * @var array<string>
     * @api
     */
    protected static $propertyNames = [];

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
     */
    private array $properties = [];

    public function __construct()
    {
        $this->initialiseProperties();
        $this->addAdditionalProperties();
    }

    private function initialiseProperties(): void
    {
        $this->properties = \array_fill_keys(static::$propertyNames, null);
    }

    /**
     * @internal
     */
    protected function addAdditionalProperties(): void
    {
        $cacheEntryIdentifier = 'additionalTypeProperties-' . \str_replace('\\', '_', static::class);
        $cache = GeneralUtility::makeInstance(CacheManager::class)->getCache(Extension::CACHE_IDENTIFIER);
        $additionalProperties = $cache->get($cacheEntryIdentifier);
        if ($additionalProperties === false) {
            $event = new RegisterAdditionalTypePropertiesEvent(static::class);

            /** @var EventDispatcherInterface $eventDispatcher */
            $eventDispatcher = GeneralUtility::makeInstance(EventDispatcher::class);
            $event = $eventDispatcher->dispatch($event);

            $additionalProperties = $event->getAdditionalProperties();
            $cache->set($cacheEntryIdentifier, $additionalProperties, [], 0);
        }

        if ($additionalProperties === []) {
            return;
        }

        $this->properties = \array_merge(
            $this->properties,
            \array_fill_keys($additionalProperties, null)
        );

        \ksort($this->properties);
    }

    public function getId(): ?string
    {
        return $this->id instanceof NodeIdentifierInterface ? $this->id->getId() : null;
    }

    public function setId($id): self
    {
        if (! $this->isValidDataTypeForId($id)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Value for id has not a valid data type (given: "%s"). Valid types are: null, string, instanceof NodeIdentifierInterface',
                    \get_debug_type($id)
                ),
                1620654936
            );
        }

        if ($id === '') {
            $id = null;
        }

        if (\is_string($id)) {
            $id = new NodeIdentifier($id);
        }

        $this->id = $id;

        return $this;
    }

    /**
     * @param NodeIdentifierInterface|string|null $id
     */
    private function isValidDataTypeForId($id): bool
    {
        return $id === null
            || \is_string($id)
            || $id instanceof NodeIdentifierInterface;
    }

    public function hasProperty(string $propertyName): bool
    {
        try {
            $this->checkPropertyExists($propertyName);
        } catch (\DomainException $e) {
            return false;
        }

        return true;
    }

    public function getProperty(string $propertyName)
    {
        $this->checkPropertyExists($propertyName);

        return $this->properties[$propertyName];
    }

    private function checkPropertyExists(string $propertyName): void
    {
        if (! \array_key_exists($propertyName, $this->properties)) {
            $type = $this->getType();
            throw new \DomainException(
                \sprintf(
                    'Property "%s" is unknown for type "%s"',
                    $propertyName,
                    \is_array($type) ? \implode(' / ', $type) : $type
                ),
                1561829996
            );
        }
    }

    public function setProperty(string $propertyName, $propertyValue): self
    {
        $propertyValue = $this->stringifyNumericValue($propertyValue);
        $this->checkProperty($propertyName, $propertyValue);

        $this->properties[$propertyName] = $propertyValue;

        return $this;
    }

    /**
     * If the value is a numeric one, stringify it
     *
     * @param mixed $value
     * @return string|mixed
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

        if (! $this->isValidDataTypeForPropertyValue($propertyValue)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Value for property "%s" has not a valid data type (given: "%s"). Valid types are: null, string, int, array, bool, instanceof TypeInterface, instanceof NodeIdentifierInterface',
                    $propertyName,
                    \get_debug_type($propertyValue)
                ),
                1561830012
            );
        }
    }

    /**
     * Returns true, if data type of property value is allowed
     *
     * @param mixed $propertyValue
     */
    private function isValidDataTypeForPropertyValue($propertyValue): bool
    {
        return $propertyValue === null
            || \is_string($propertyValue)
            || \is_array($propertyValue)
            || \is_bool($propertyValue)
            || $propertyValue instanceof NodeIdentifierInterface
            || $propertyValue instanceof TypeInterface;
    }

    public function addProperty(string $propertyName, $propertyValue): self
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

    public function setProperties(array $properties): self
    {
        foreach ($properties as $propertyName => $propertyValue) {
            $this->setProperty($propertyName, $propertyValue);
        }

        return $this;
    }

    public function clearProperty(string $propertyName): self
    {
        $this->checkPropertyExists($propertyName);

        $this->properties[$propertyName] = null;

        return $this;
    }

    public function getPropertyNames(): array
    {
        return \array_keys($this->properties);
    }

    public function getType()
    {
        $type = \substr(\strrchr(static::class, '\\') ?: '', 1);
        if (\str_starts_with($type, '_')) {
            // As a class cannot start with a number an underscore prefixes the type class name
            // which is now removed (e.g. _3DModel => 3DModel)
            $type = \substr($type, 1);
        }

        return $type;
    }
}
