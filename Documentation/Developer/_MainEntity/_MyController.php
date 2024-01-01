<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly SchemaManager $schemaManager,
        private readonly TypeFactory $typeFactory,
    ) {}

    public function addMainEntity(): void
    {
        // ...

        $aggregateRating = $this->typeFactory->create('AggregateRating')
            ->setProperty('ratingValue', '4')
            ->setProperty('reviewCount', '126');

        $product = $this->typeFactory->create('Product')
            ->setProperties([
                'name' => 'Some fancy product',
                'color' => 'blue',
                'material' => 'wood',
                'image' => 'https://example.org/some-fancy-product.jpg',
                'aggregateRating' => $aggregateRating,
            ]);

        $this->schemaManager->addMainEntityOfWebPage($product);

        // ...
    }
}
