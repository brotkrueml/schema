<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Cache;

final class UnknownPageCacheIdentifierException extends \RuntimeException
{
    public static function create(): self
    {
        return new self(
            'Page cache identifier is not available',
            1752687715,
        );
    }
}
