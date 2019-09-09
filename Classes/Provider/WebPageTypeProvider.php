<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Provider;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * @internal
 */
final class WebPageTypeProvider
{
    public static function getTypesForTcaSelect(): array
    {
        $types = (new TypesProvider())->getWebPageTypes();

        \array_walk($types, function (&$type) {
            $type = [$type, $type];
        });

        return $types;
    }
}
