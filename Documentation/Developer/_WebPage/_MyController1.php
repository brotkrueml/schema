<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly SchemaManager $schemaManager,
    ) {
    }

    public function doSomething(): void
    {
        // ...

        $itemPage = TypeFactory::createType('ItemPage');
        $this->schemaManager->addType($itemPage);

        // ...
    }
}
