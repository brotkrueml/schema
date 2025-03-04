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
final class AdditionalPropertiesProvider
{
    /**
     * @var array<non-empty-string, list<class-string<AdditionalPropertiesInterface>>>
     */
    private array $additionalProperties = [];

    /**
     * @param class-string<AdditionalPropertiesInterface> $className
     */
    public function add(string $className): void
    {
        $type = (new $className())->getType();
        if (! isset($this->additionalProperties[$type])) {
            $this->additionalProperties[$type] = [];
        }
        $this->additionalProperties[$type][] = $className;
    }

    /**
     * @return list<non-empty-string>
     */
    public function getForType(string $type): array
    {
        if (! isset($this->additionalProperties[$type])) {
            return [];
        }

        $additionalPropertiesForType = [];
        foreach ($this->additionalProperties[$type] as $className) {
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
