<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function doSomething(): void
    {
        // ...

        $thing = TypeFactory::createType('Thing');
        $thing->setProperty('name', 'A thing');

        // ...
    }
}
