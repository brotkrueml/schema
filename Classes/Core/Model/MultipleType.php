<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

use Brotkrueml\Schema\Core\Exception\InvalidNumberOfTypesException;
use Brotkrueml\Schema\Core\Exception\SameTypeForMultipleTypeException;

/**
 * This class represents a multiple type.
 * Do not instantiate it directly but use the TypeFactory to create
 * a multiple type model, for example:
 *
 * $productService = $this->typeFactory->create('Product', 'Service');
 */
final class MultipleType extends AbstractBaseType
{
    /**
     * @var string[]
     */
    private array $typeNames = [];

    public function __construct(TypeInterface ...$type)
    {
        $this->storeTypeNames($type);
        $this->checkForSameTypes();
        $this->checkNumberOfTypes();
        $this->mergePropertiesFromSingleTypes($type);
    }

    /**
     * @param TypeInterface[] $types
     */
    private function storeTypeNames(array $types): void
    {
        $this->typeNames = \array_map(
            static fn(TypeInterface $type): string => $type->getType(),
            $types,
        );
        \sort($this->typeNames);
    }

    private function checkForSameTypes(): void
    {
        $uniqueTypeNames = \array_unique($this->typeNames);
        if (\count($this->typeNames) !== \count($uniqueTypeNames)) {
            throw SameTypeForMultipleTypeException::fromSingleTypes($this->typeNames);
        }
    }

    private function checkNumberOfTypes(): void
    {
        if (\count($this->typeNames) < 2) {
            throw InvalidNumberOfTypesException::fromSingleTypes($this->typeNames);
        }
    }

    /**
     * @param TypeInterface[] $types
     */
    private function mergePropertiesFromSingleTypes(array $types): void
    {
        $propertyNames = [];
        foreach ($types as $type) {
            $propertyNames = \array_merge($propertyNames, $type->getPropertyNames());
        }
        \sort($propertyNames);

        $this->properties = \array_fill_keys($propertyNames, null);
    }

    /**
     * @return string[]
     */
    public function getType(): array
    {
        return $this->typeNames;
    }
}
