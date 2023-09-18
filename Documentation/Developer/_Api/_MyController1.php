<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly TypeFactory $typeFactory,
    ) {
    }

    public function doSomething(): void
    {
        // ...

        $person = $this->typeFactory->create('Person');

        // ...
    }
}
