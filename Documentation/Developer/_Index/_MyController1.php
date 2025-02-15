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

        $thing = $this->typeFactory->create('Thing');
        $thing->setProperty('name', 'A thing');

        // ...
    }
}
