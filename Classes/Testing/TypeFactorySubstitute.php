<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Testing;

use Brotkrueml\Schema\Core\Model\MultipleType;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Type\ModelClassNotFoundException;
use Brotkrueml\Schema\Type\TypeFactoryInterface;

final class TypeFactorySubstitute implements TypeFactoryInterface
{
    /**
     * @var array<string, class-string>
     */
    private array $types = [];

    public function addType(string $name, string $class): self
    {
        $implementations = \class_implements($class);
        if (! isset($implementations[TypeInterface::class])) {
            throw new \InvalidArgumentException($class . ' is not of type TypeInterface!');
        }

        $this->types[$name] = $class;

        return $this;
    }

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

    private function createSingle($type): TypeInterface
    {
        if (isset($this->types[$type])) {
            return new $this->types[$type]();
        }

        throw ModelClassNotFoundException::fromType($type);
    }

    /**
     * @param list<string> $types
     */
    private function createMultiple(array $types): MultipleType
    {
        return new MultipleType(...\array_map(
            fn(string $type): TypeInterface => $this->createSingle($type),
            $types,
        ));
    }
}
