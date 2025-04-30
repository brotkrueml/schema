<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema;

/**
 * @internal
 */
final class Extension
{
    public const KEY = 'schema';

    public const LANGUAGE_PATH_DATABASE = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/locallang_db.xlf';
    public const LANGUAGE_PATH_DEFAULT = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/locallang.xlf';

    public const JSONLD_TEMPLATE = '<script type="application/ld+json" id="ext-schema-jsonld">%s</script>';
}
