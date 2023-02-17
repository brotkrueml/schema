<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Event;

final class RegisterAdditionalTypePropertiesEvent
{
    /**
     * @var list<string>
     */
    private array $additionalProperties = [];

    public function __construct(
        private readonly string $type
    ) {
    }

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
        }
    }
}
