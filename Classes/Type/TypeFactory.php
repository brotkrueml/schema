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
    public function create(string ...$type): TypeInterface
    {
        if ($type === []) {
            throw new \DomainException(
                'At least one type has to be given as argument',
                1621787452,
            );
        }

        $type = \array_unique($type);
        if (\count($type) === 1) {
            return $this->createSingle($type[0]);
        }

        return $this->createMultiple($type);
    }

    /**
     * @deprecated since 3.0.0, will be removed in 4.0. Inject the TypeFactory into your class and call the method create() on that object.
     */
    public static function createType(string ...$type): TypeInterface
    {
        \trigger_error(
            'Calling the static method TypeFactory::createType() is deprecated since version 3.0.0 and will be removed in version 4.0. Inject the TypeFactory into your class and call the method create() on that object.',
            \E_USER_DEPRECATED,
        );

        return (new self())->create(...$type);
    }

    private function createSingle(string $type): TypeInterface
    {
        /** @var TypeProvider $typeProvider */
        $typeProvider = GeneralUtility::makeInstance(TypeProvider::class);
        $typeClass = $typeProvider->getModelClassNameForType($type);

        /** @var TypeInterface $type */
        $type = new $typeClass();

        return $type;
    }

    /**
     * @param string[] $types
     */
    private function createMultiple(array $types): MultipleType
    {
        return new MultipleType(...\array_map(
            fn (string $type): TypeInterface => $this->createSingle($type),
            $types,
        ));
    }
}
