<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactoryInterface;

final class MyController
{
    public function __construct(
        private readonly SchemaManager $schemaManager,
        private readonly TypeFactoryInterface $typeFactory,
    ) {}

    public function doSomething(): void
    {
        // ...

        $thing = $this->typeFactory->create('Thing');
        $thing->setProperty('name', 'A thing');

        $this->schemaManager->addType($thing);

        // ...
    }
}
