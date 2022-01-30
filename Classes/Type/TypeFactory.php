<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Type;

use Brotkrueml\Schema\Core\Model\MultipleType;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class TypeFactory
{
    private function __construct()
    {
    }

    public static function createType(string ...$type): TypeInterface
    {
        if ($type === []) {
            throw new \DomainException(
                'At least one type has to be given as argument',
                1621787452
            );
        }

        $type = \array_unique($type);
        if (\count($type) === 1) {
            return self::createSingleType($type[0]);
        }

        return self::createMultipleType($type);
    }

    private static function createSingleType(string $type): TypeInterface
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

    /**
     * @param string[] $types
     */
    private static function createMultipleType(array $types): MultipleType
    {
        return new MultipleType(...\array_map(
            static fn (string $type): TypeInterface => self::createSingleType($type),
            $types
        ));
    }
}
