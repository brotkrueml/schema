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

/**
 * Provides a user function used as itemProcFunc in TCA defintion
 * for pages.tx_schema_webpagetype field
 * @internal
 */
final class WebPageTypes
{
    public function __construct(
        private readonly TypeProvider $typeProvider,
    ) {
    }

    /**
     * @param array{items: string[]} $params
     */
    public function get(&$params): void
    {
        $webPageTypes = $this->typeProvider->getWebPageTypes();
        \sort($webPageTypes);
        foreach ($webPageTypes as $type) {
            $params['items'][] = [$type, $type];
        }
    }
}
