<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Exception;

final class SameTypeForMultipleTypeException extends \DomainException
{
    /**
     * @param string[] $singleTypes
     */
    public static function fromSingleTypes(array $singleTypes): self
    {
        return new self(
            \sprintf(
                'Only different types can be used as arguments for a multiple type, "%s" given',
                \implode(', ', $singleTypes),
            ),
            1621871950,
        );
    }
}
