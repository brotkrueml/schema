<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Type\AdditionalPropertiesProvider;
use Brotkrueml\Schema\Type\TypeFactory;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

abstract class AbstractType extends AbstractBaseType
{
    /**
     * The properties of a specific type
     * These are defined in the concrete type model class
     *
     * @var list<string>
     * @api
     */
    protected static array $propertyNames = [];

    /**
     * The getType() method resolves the type depending on the "Type" attribute via reflection.
     * Once a specific type is resolved, it is cached in this variable.
     *
     * @var array<class-string, string>
     * @internal
     */
    protected static array $resolvedTypes = [];

    /**
     * @deprecated Instantiating a type model class manually with "new" is discouraged and might not work with v4.0 anymore.
     *             Use the TypeFactory instead.
     */
    public function __construct()
    {
        $this->triggerDeprecationOnManualInstantiation();
        $this->initialiseProperties();
        $this->addAdditionalProperties();
    }

    private function triggerDeprecationOnManualInstantiation(): void
    {
        $file = '';
        $line = 0;
        $backtraceLimit = 5;
        $backtrace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, $backtraceLimit);
        // The first item is this method, we can skip it
        for ($i = 1; $i < $backtraceLimit - 1; $i++) {
            $calledClass = $backtrace[$i]['class'] ?? '';
            $callingClass = $backtrace[$i + 1]['class'] ?? '';
            if ($calledClass === self::class && ($callingClass !== TypeFactory::class)) {
                $file = $backtrace[$i]['file'] ?? 'unknown';
                $line = $backtrace[$i]['line'] ?? 0;
                break;
            }
        }

        if ($file !== '') {
            $message = \sprintf(
                'Manual instantiation of type "%s" in file "%s", line "%d" is discouraged and might not work with EXT:schema v4.0 anymore. Use the TypeFactory instead.',
                $this->getType(),
                $file,
                $line,
            );
            \trigger_error($message, \E_USER_DEPRECATED);
        }
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
            /** @var AdditionalPropertiesProvider $additionalPropertiesProvider */
            $additionalPropertiesProvider = GeneralUtility::makeInstance(AdditionalPropertiesProvider::class);
            $additionalProperties = $additionalPropertiesProvider->getForType($this->getType());

            $event = new RegisterAdditionalTypePropertiesEvent(static::class);
            /** @var EventDispatcherInterface $eventDispatcher */
            $eventDispatcher = GeneralUtility::makeInstance(EventDispatcherInterface::class);
            /** @var RegisterAdditionalTypePropertiesEvent $event */
            $event = $eventDispatcher->dispatch($event);
            if ($event->haveAdditionalPropertiesRegistered()) {
                $message = \sprintf(
                    'Using the RegisterAdditionalTypePropertiesEvent for "%s" is deprecated since EXT:schema version 3.10.0, it will be removed in version 4.0.0. To register additional properties create a class implementing AdditionalPropertiesInterface. Consult the docs for details.',
                    $this->getType(),
                );
                \trigger_error($message, \E_USER_DEPRECATED);
            }

            $additionalProperties = [...$additionalProperties, ...$event->getAdditionalProperties()];
            $cache->set($cacheEntryIdentifier, $additionalProperties, [], 0);
        }

        if ($additionalProperties === []) {
            return;
        }

        $this->properties = \array_merge(
            $this->properties,
            \array_fill_keys($additionalProperties, null),
        );

        \ksort($this->properties);
    }

    public function getType(): string
    {
        if (! isset(static::$resolvedTypes[static::class])) {
            $reflector = new \ReflectionClass(static::class);
            $typeAttribute = $reflector->getAttributes(Type::class)[0] ?? null;
            if (! $typeAttribute instanceof \ReflectionAttribute) {
                throw new \DomainException(
                    \sprintf(
                        'Type model class "%s" does not define the required attribute "%s".',
                        static::class,
                        Type::class,
                    ),
                    1697271711,
                );
            }
            static::$resolvedTypes[static::class] = $typeAttribute->getArguments()[0] ?? $typeAttribute->getArguments()['type'];
        }

        return static::$resolvedTypes[static::class];
    }
}
