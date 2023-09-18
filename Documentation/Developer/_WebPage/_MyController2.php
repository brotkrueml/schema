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

        $aggregateRating = TypeFactory::createType('AggregateRating')
            ->setProperty('ratingValue', '4')
            ->setProperty('reviewCount', '126')
        ;

        $product = TypeFactory::createType('Product')
            ->setProperties([
                'name' => 'Some fancy product',
                'color' => 'blue',
                'material' => 'wood',
                'image' => 'https://example.org/some-fancy-product.jpg',
                'aggregateRating' => $aggregateRating,
            ])
        ;

        $itemPage = TypeFactory::createType('ItemPage')
            ->setProperty('mainEntity', $product)
        ;

        $this->schemaManager->addType($itemPage);

        // ...
    }
}
