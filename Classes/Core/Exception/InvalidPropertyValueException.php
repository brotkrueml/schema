<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Exception;

final class InvalidPropertyValueException extends \InvalidArgumentException
{
    public static function fromValueType(string $propertyName, string $propertyValueType): self
    {
        return new self(
            \sprintf(
                'Value for property "%s" has not a valid data type (given: "%s"). Valid types are: null, string, int, array, bool, instanceof TypeInterface, instanceof NodeIdentifierInterface',
                $propertyName,
                $propertyValueType,
            ),
            1561830012,
        );
    }
}
