<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly TypeFactory $typeFactory,
    ) {}

    public function doSomething(): void
    {
        // ...

        $positiveNotes = [
            'Tougher and water resistant design.',
            'Cheery bright colours and solid feel.',
            'Excellent amplification.',
        ];

        $review = $this->typeFactory->create('Review');
        $review->setProperty('name', 'Megaphone 11 review');

        $itemList = $this->typeFactory->create('ItemList');
        foreach ($positiveNotes as $index => $note) {
            $item = $this->typeFactory->create('ListItem');
            $item->setProperties([
                'position' => $index + 1,
                'name' => $note,
            ]);
            $itemList->addProperty('itemListElement', $item);
        }

        $review->setProperty('positiveNotes', $itemList);

        // ...
    }
}
