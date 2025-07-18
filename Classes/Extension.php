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
final readonly class Extension
{
    public const KEY = 'schema';

    public const LANGUAGE_PATH_DATABASE = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/locallang_db.xlf';
    public const LANGUAGE_PATH_DEFAULT = 'LLL:EXT:' . self::KEY . '/Resources/Private/Language/locallang.xlf';

    public const JSONLD_TEMPLATE = '<script type="application/ld+json" id="ext-schema-jsonld">%s</script>';

    public const CACHE_IDENTIFIER = 'tx_' . self::KEY;
    public const CACHE_MARKUP_SERVICE_ID = 'cache.' . self::CACHE_IDENTIFIER;

    public const RUNTIME_CACHE_PAGE_CACHE_IDENTIFIER = 'tx_' . self::KEY . '_page_cache_identifier';
}
