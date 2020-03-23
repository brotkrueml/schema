<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Core\Model;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Model\DataType\Boolean;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\EventDispatcher\EventDispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

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
     *
     * @var string|null
     */
    private $id;

    /**
     * The properties of a specific type with their corresponding value:
     * <propertyName> => <propertyValue>
     * Also the additional properties added by an event listener are included
     *
     * @var array<string, mixed>
     */
    private $properties = [];

    /**
     * The fully rendered type with all children as array
     *
     * @var array
     */
    private $result = [];

    public function __construct()
    {
        $this->initialiseProperties();
        $this->addAdditionalProperties();
    }

    private function initialiseProperties(): void
    {
        $this->properties = \array_fill_keys(static::$propertyNames, null);
    }

    private function addAdditionalProperties(): void
    {
        $cacheEntryIdentifier = 'additionalTypeProperties-' . \str_replace('\\', '_', static::class);
        $cache = GeneralUtility::makeInstance(CacheManager::class)->getCache('tx_schema');
        if (($additionalProperties = $cache->get($cacheEntryIdentifier)) === false) {
            $event = new RegisterAdditionalTypePropertiesEvent(static::class);

            if (\class_exists(EventDispatcher::class)) {
                /** @var EventDispatcherInterface $eventDispatcher */
                $eventDispatcher = GeneralUtility::makeInstance(EventDispatcher::class);
                $event = $eventDispatcher->dispatch($event);
            }

            /** @var Dispatcher $signalSlotDispatcher */
            $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);
            $signalSlotDispatcher->dispatch(self::class, 'registerAdditionalTypeProperties', [$event]);

            $additionalProperties = $event->getAdditionalProperties();
            $cache->set($cacheEntryIdentifier, $additionalProperties, [], 0);
        }

        if (empty($additionalProperties)) {
            return;
        }

        $this->properties = \array_merge(
            $this->properties,
            \array_fill_keys($additionalProperties, null)
        );

        \ksort($this->properties);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasProperty(string $propertyName): bool
    {
        try {
            $this->checkPropertyExists($propertyName);
        } catch (\DomainException $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getProperty(string $propertyName)
    {
        $this->checkPropertyExists($propertyName);

        return $this->properties[$propertyName];
    }

    private function checkPropertyExists(string $propertyName): void
    {
        if (!\array_key_exists($propertyName, $this->properties)) {
            throw new \DomainException(
                \sprintf('Property "%s" is unknown for type "%s"', $propertyName, $this->getType()),
                1561829996
            );
        }
    }

    /**
     * @inheritDoc
     */
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

        if (!$this->isValidDataTypeForPropertyValue($propertyValue)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Value for property "%s" has not a valid data type (given: "%s"). Valid types are: null, string, int, array, bool, instanceof TypeInterface',
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
            || \is_bool($propertyValue)
            || $propertyValue instanceof TypeInterface;
    }

    /**
     * @inheritDoc
     */
    public function addProperty(string $propertyName, $propertyValue): self
    {
        $propertyValue = $this->stringifyNumericValue($propertyValue);
        $this->checkProperty($propertyName, $propertyValue);

        if ($this->properties[$propertyName] === null) {
            $this->properties[$propertyName] = $propertyValue;

            return $this;
        }

        if (\is_array($this->properties[$propertyName])) {
            if (\is_string($propertyValue) || \is_bool($propertyValue) || $propertyValue instanceof TypeInterface) {
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

    /**
     * @inheritDoc
     */
    public function setProperties(array $properties): self
    {
        foreach ($properties as $propertyName => $propertyValue) {
            $this->setProperty($propertyName, $propertyValue);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function clearProperty(string $propertyName): self
    {
        $this->checkPropertyExists($propertyName);

        $this->properties[$propertyName] = null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPropertyNames(): array
    {
        return \array_keys($this->properties);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        $propertiesNotEmpty = \array_filter($this->getPropertyNames(), function ($property) {
            return \is_bool($this->properties[$property]) ?: !empty($this->properties[$property]);
        });

        return empty($propertiesNotEmpty);
    }

    private function getType(): string
    {
        return \substr(\strrchr(static::class, '\\') ?: '', 1);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $this->result = [];

        $this->addTypeToResultArray();
        $this->addIdToResultArray();
        $this->addPropertiesToResultArray();

        return $this->result;
    }

    private function addTypeToResultArray(): void
    {
        $this->result['@type'] = $this->getType();
    }

    private function addIdToResultArray(): void
    {
        if ($this->id) {
            $this->result['@id'] = $this->id;
        }
    }

    private function addPropertiesToResultArray(): void
    {
        foreach ($this->getPropertyNames() as $property) {
            if ($this->properties[$property] === null || $this->properties[$property] === '') {
                continue;
            }

            if (\is_array($this->properties[$property])) {
                $this->result[$property] = [];
                foreach ($this->properties[$property] as $singleValue) {
                    $this->result[$property][] = $this->getPropertyValueForResult($singleValue);
                }
                continue;
            }

            $this->result[$property] = $this->getPropertyValueForResult($this->properties[$property]);
        }
    }

    /**
     * @param TypeInterface|bool|string $value
     * @return array|string
     */
    private function getPropertyValueForResult($value)
    {
        if ($value instanceof TypeInterface) {
            return $value->toArray();
        }

        if (\is_bool($value)) {
            return Boolean::convertToTerm($value);
        }

        return $value;
    }
}
