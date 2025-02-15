<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactoryInterface;

final class MyController
{
    public function __construct(
        private readonly TypeFactoryInterface $typeFactory,
    ) {}

    public function doSomething(): void
    {
        // ...

        $person = $this->typeFactory->create('Person');
        $event = $this->typeFactory->create('Event');

        // ...

        $person->setProperty('performerIn', $event);

        // ...
    }
}
