<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Manager;

use Brotkrueml\Schema\Core\Model\TypeInterface;

/**
 * This bag holds the assigned main entity types. Additional types can be added
 * via the add() method. The add method returns an array of not prioritised types
 * when a type with priority is added.
 *
 * @internal
 */
final class MainEntityOfWebPageBag implements \Countable
{
    /**
     * @var TypeInterface[]
     */
    private array $types = [];
    private bool $isPrioritised = false;

    /**
     * @return TypeInterface[]
     */
    public function add(TypeInterface $type, bool $typeIsPrioritised): array
    {
        if (! $typeIsPrioritised && $this->isPrioritised) {
            return [$type];
        }

        $notPrioritisedTypes = [];
        if ($typeIsPrioritised && ! $this->isPrioritised) {
            $notPrioritisedTypes = $this->types;
            $this->types = [];
            $this->isPrioritised = true;
        }

        $this->types[] = $type;

        return $notPrioritisedTypes;
    }

    /**
     * @return TypeInterface[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function count(): int
    {
        return \count($this->types);
    }
}
