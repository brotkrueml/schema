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

        $productAndService = TypeFactory::createType('Product', 'Service');
        $productAndService
            ->setId('https://example.org/#my-product-and-service')
            ->setProperty('name', 'My product and service')
            ->setProperty('manufacturer', 'Acme Ltd.') // from Product
            ->setProperty('provider', 'Acme Ltd.') // from Service
        ;
        $this->schemaManager->addType($productAndService);

        // ...
    }
}
