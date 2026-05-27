<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Type;

use Brotkrueml\Schema\Core\AdditionalPropertiesInterface;

/**
 * @internal
 */
final readonly class AdditionalPropertiesProvider
{
    /**
     * @param array<non-empty-string, list<class-string<AdditionalPropertiesInterface>>> $additionalPropertiesByType
     */
    public function __construct(
        private array $additionalPropertiesByType = [],
    ) {}

    /**
     * @return list<non-empty-string>
     */
    public function getForType(string $type): array
    {
        if (! isset($this->additionalPropertiesByType[$type])) {
            return [];
        }

        $additionalPropertiesForType = [];
        foreach ($this->additionalPropertiesByType[$type] as $className) {
            $additionalPropertiesForType = [
                ...$additionalPropertiesForType,
                ...(new $className())->getAdditionalProperties(),
            ];
        }

        $additionalPropertiesForType = \array_unique($additionalPropertiesForType);
        \sort($additionalPropertiesForType);

        return $additionalPropertiesForType;
    }
}
