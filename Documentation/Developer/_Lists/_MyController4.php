<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Core\Model\BlankNodeIdentifier;
use Brotkrueml\Schema\Core\Model\OrderedList;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly SchemaManager $schemaManager,
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

        $itemIds = [];
        for ($i = 0; $i < \count($positiveNotes); $i++) {
            $itemIds[$i] = new BlankNodeIdentifier();
            $item = $this->typeFactory->create('ListItem');
            $item->setId($itemIds[$i]->getId());
            $item->setProperty('name', $positiveNotes[$i]);
            $this->schemaManager->addType($item);
        }

        $review->setProperty('positiveNotes', new OrderedList(...$itemIds));

        // ...
    }
}
