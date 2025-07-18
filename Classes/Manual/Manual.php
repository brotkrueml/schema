<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Manual;

/**
 * Manual DTO
 * @internal
 */
final readonly class Manual
{
    /**
     * @param non-empty-string $link
     */
    public function __construct(
        public Publisher $publisher,
        public string $text,
        public string $link,
    ) {}
}
