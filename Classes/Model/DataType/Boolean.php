<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\DataType;

/**
 * Boolean DataType model
 * @api
 */
final class Boolean
{
    public const FALSE = 'https://schema.org/False';
    public const TRUE = 'https://schema.org/True';

    public static function convertToTerm(bool $value): string
    {
        return $value ? self::TRUE : self::FALSE;
    }
}
