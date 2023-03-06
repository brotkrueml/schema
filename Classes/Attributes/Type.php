<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class Type
{
    /**
     * @param non-empty-string $type
     */
    public function __construct(
        public readonly string $type,
    ) {
    }
}
