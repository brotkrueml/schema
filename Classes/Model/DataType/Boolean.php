<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\DataType;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Boolean DataType model
 * @api
 */
final class Boolean
{
    public const FALSE = 'http://schema.org/False';
    public const TRUE = 'http://schema.org/True';

    public static function convertToType(bool $value): string
    {
        return $value ? self::TRUE : self::FALSE;
    }
}
