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
use TYPO3\CMS\Core\Information\Typo3Version;

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
    public function get(array &$params): void
    {
        $webPageTypes = $this->typeProvider->getWebPageTypes();
        \sort($webPageTypes);
        $majorTypo3Version = (new Typo3Version())->getMajorVersion();
        foreach ($webPageTypes as $type) {
            if ($majorTypo3Version < 12) {
                $params['items'][] = [$type, $type];
                continue;
            }

            $params['items'][] = [
                'label' => $type,
                'value' => $type,
            ];
        }
    }
}
