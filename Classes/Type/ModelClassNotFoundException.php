<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Type;

final class ModelClassNotFoundException extends \DomainException
{
    public static function fromType(string $type): self
    {
        return new self(
            \sprintf(
                'No model class for type "%s" available!',
                $type,
            ),
            1586590157,
        );
    }
}
