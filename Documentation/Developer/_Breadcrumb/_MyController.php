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

    public function createBreadcrumb(array $breadcrumb): void
    {
        // ...

        $breadcrumbList = TypeFactory::createType('BreadcrumbList');
        $counter = 0;
        foreach ($breadcrumb as $name => $url) {
            $counter++;

            $breadcrumbList->addProperty(
                'itemListElement',
                TypeFactory::createType('ListItem')
                    ->setProperties([
                        'name' => $name,
                        'item' => $url,
                        'position' => $counter,
                    ]),
            );
        }
        $this->schemaManager->addType($breadcrumbList);

        // ...
    }
}
