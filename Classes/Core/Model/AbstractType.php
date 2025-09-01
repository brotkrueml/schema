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
use Brotkrueml\Schema\Type\AdditionalPropertiesProvider;

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

    public function __construct(
        private readonly AdditionalPropertiesProvider $additionalPropertiesProvider,
    ) {
        $this->initialiseProperties();
        $this->addAdditionalProperties();
    }

    private function initialiseProperties(): void
    {
        $this->properties = \array_fill_keys(static::$propertyNames, null);
    }

    private function addAdditionalProperties(): void
    {
        $additionalProperties = $this->additionalPropertiesProvider->getForType($this->getType());
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
