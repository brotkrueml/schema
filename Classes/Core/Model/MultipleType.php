<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

final class MultipleType extends AbstractType
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
        $this->mergePropertyNamesFromSingleTypes($type);
        parent::__construct();
    }

    private function storeTypeNames(array $types): void
    {
        /** @psalm-suppress InvalidReturnType,InvalidReturnStatement */
        $this->typeNames = \array_map(
            static fn (TypeInterface $type): string => $type->getType(),
            $types
        );
        \sort($this->typeNames);
    }

    private function checkForSameTypes(): void
    {
        $uniqueTypeNames = \array_unique($this->typeNames);
        if (\count($this->typeNames) !== \count($uniqueTypeNames)) {
            throw new \DomainException(
                \sprintf('Only different types can be used as arguments for a multiple type, "%s" given', \implode(', ', $this->typeNames)),
                1621871950
            );
        }
    }

    private function checkNumberOfTypes(): void
    {
        if (\count($this->typeNames) < 2) {
            throw new \DomainException(
                \sprintf('At least two types have to be assigned, %d given', \count($this->typeNames)),
                1621871446
            );
        }
    }

    private function mergePropertyNamesFromSingleTypes(array $types): void
    {
        $propertyNames = [];
        foreach ($types as $type) {
            $propertyNames = \array_merge($propertyNames, $type->getPropertyNames());
        }
        \sort($propertyNames);
        self::$propertyNames = \array_unique($propertyNames);
    }

    protected function addAdditionalProperties(): void
    {
        // not necessary
    }

    public function getType()
    {
        return $this->typeNames;
    }
}
