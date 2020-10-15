<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Type;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class TypeFactory
{
    private function __construct()
    {
    }

    public static function createType(string $type): TypeInterface
    {
        /** @var TypeRegistry $typeRegistry */
        $typeRegistry = GeneralUtility::makeInstance(TypeRegistry::class);
        $typeClass = $typeRegistry->resolveModelClassFromType($type);

        if ($typeClass === null) {
            throw new \DomainException(
                \sprintf('No model class for type "%s" available!', $type),
                1586590157
            );
        }

        /** @var TypeInterface $type */
        $type = new $typeClass();

        return $type;
    }
}
