<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\Model;

/**
 * Holds an ordered list which will be rendered as "@list" in JSON-LD
 * @see https://blog.schema.org/2026/06/17/supporting-ordering-in-schema-org/
 */
final readonly class OrderedList implements OrderedListInterface
{
    /**
     * @var list<NodeIdentifierInterface|string>
     */
    private array $items;

    public function __construct(NodeIdentifierInterface|string ...$items)
    {
        $this->items = \array_values($items);
    }

    /**
     * @return list<NodeIdentifierInterface|string>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
