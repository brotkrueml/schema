<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Core\Model\BlankNodeIdentifier;
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

        $nodeIdentifier = new BlankNodeIdentifier();

        $person1 = TypeFactory::createType('Person');
        $person1->setId($nodeIdentifier);
        $person1->setProperty('name', 'John Smith');

        $person2 = TypeFactory::createType('Person');
        $person2->setProperty('name', 'Sarah Jane Smith');
        $person2->setProperty('knows', $nodeIdentifier);

        $person1->setProperty('knows', $person2);

        $this->schemaManager->addType($person1);
        $this->schemaManager->addType($person2);

        // ...
    }
}
