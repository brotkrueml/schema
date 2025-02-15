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

    public function createVirtualLocation(): void
    {
        // ...

        $location = $this->typeFactory->create('VirtualLocation');
        $location->setProperty('url', 'https://example.com/my-webinar-12345/register');
        $this->schemaManager->addType($location);

        // ...
    }
}
