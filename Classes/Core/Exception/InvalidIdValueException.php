<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Exception;

final class InvalidIdValueException extends \InvalidArgumentException
{
    public static function fromValueType(string $valueType): self
    {
        return new self(
            \sprintf(
                'Value for id has not a valid data type (given: "%s"). Valid types are: null, string, instanceof NodeIdentifierInterface',
                $valueType,
            ),
            1620654936,
        );
    }
}
