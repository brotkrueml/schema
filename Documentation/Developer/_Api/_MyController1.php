<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function doSomething(): void
    {
        // ...

        $person = TypeFactory::createType('Person');

        // ...
    }
}
