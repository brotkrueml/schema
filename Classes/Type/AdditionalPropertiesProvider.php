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
     * @param class-string<AdditionalPropertiesInterface> $class
     */
    public function add(string $class): void
    {
        $type = (new $class())->getType();
        if (! isset($this->additionalProperties[$type])) {
            $this->additionalProperties[$type] = [];
        }
        $this->additionalProperties[$type][] = $class;
    }

    /**
     * @return list<class-string<AdditionalPropertiesInterface>>
     */
    public function get(string $type): array
    {
        return $this->additionalProperties[$type] ?? [];
    }
}
