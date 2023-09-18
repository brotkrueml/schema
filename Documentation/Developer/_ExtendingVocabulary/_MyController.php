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

    public function createVirtualLocation(): void
    {
        // ...

        $location = TypeFactory::createType('VirtualLocation');
        $location->setProperty('url', 'https://example.com/my-webinar-12345/register');
        $this->schemaManager->addType($location);

        // ...
    }
}
