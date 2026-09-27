<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Core\Model\OrderedList;
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
        $review->setProperty('positiveNotes', new OrderedList(...$positiveNotes));

        // ...
    }
}
