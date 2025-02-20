<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Exception;

final class UnknownPropertyException extends \DomainException
{
    /**
     * @param string|string[] $type
     */
    public static function fromPropertyName(string|array $type, string $propertyName): self
    {
        return new self(
            \sprintf(
                'Property "%s" is unknown for type "%s"',
                $propertyName,
                \is_array($type) ? \implode(' / ', $type) : $type,
            ),
            1561829996,
        );
    }
}
