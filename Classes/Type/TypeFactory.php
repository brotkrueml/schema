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
            fn(string $type): TypeInterface => $this->createSingle($type),
            $types,
        ));
    }
}
