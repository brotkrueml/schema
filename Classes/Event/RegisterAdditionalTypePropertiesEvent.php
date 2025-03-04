<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Event;

/**
 * @deprecated since 3.10.0, will be removed in 4.0.0. To register additional properties create a class implementing AdditionalPropertiesInterface. Consult the docs for details.
 */
final class RegisterAdditionalTypePropertiesEvent
{
    /**
     * @var list<string>
     */
    private array $additionalProperties = [];
    private bool $haveAdditionalPropertiesRegistered = false;

    public function __construct(
        private readonly string $type,
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function getAdditionalProperties(): array
    {
        return $this->additionalProperties;
    }

    public function registerAdditionalProperty(string $propertyName): void
    {
        if (! \in_array($propertyName, $this->additionalProperties, true)) {
            $this->additionalProperties[] = $propertyName;
            $this->haveAdditionalPropertiesRegistered = true;
        }
    }

    /**
     * @internal
     */
    public function haveAdditionalPropertiesRegistered(): bool
    {
        return $this->haveAdditionalPropertiesRegistered;
    }
}
