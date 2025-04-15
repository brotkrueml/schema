<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\UserFunctions\FormEngine;

use Brotkrueml\Schema\Type\TypeProvider;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

/**
 * Provides a user function used as itemProcFunc in TCA definition
 * for pages.tx_schema_webpagetype field
 * @internal
 */
#[Autoconfigure(public: true)]
final class WebPageTypes
{
    public function __construct(
        private readonly TypeProvider $typeProvider,
    ) {}

    /**
     * @param array{items: non-empty-array<array{label: string, value: string}|array{string, string}>} $params
     */
    public function get(array &$params): void
    {
        $webPageTypes = $this->typeProvider->getWebPageTypes();
        \sort($webPageTypes);
        foreach ($webPageTypes as $type) {
            $params['items'][] = [
                'label' => $type,
                'value' => $type,
            ];
        }
    }
}
