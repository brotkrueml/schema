<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Attributes;

use Brotkrueml\Schema\Manual\Publisher;

/**
 * @internal
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
final class Manual
{
    /**
     * @param non-empty-string $link
     */
    public function __construct(
        public readonly Publisher $provider,
        public readonly string $text,
        public readonly string $link,
    ) {}
}
