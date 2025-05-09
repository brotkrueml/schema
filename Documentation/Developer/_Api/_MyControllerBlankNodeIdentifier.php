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
        private readonly TypeFactory $typeFactory,
    ) {}

    public function doSomething(): void
    {
        // ...

        $johnSmithId = new BlankNodeIdentifier();

        $person1 = $this->typeFactory->create('Person');
        $person1->setId($johnSmithId);
        $person1->setProperty('name', 'John Smith');

        $person2 = $this->typeFactory->create('Person');
        $person2->setProperty('name', 'Sarah Jane Smith');
        $person2->setProperty('knows', $johnSmithId);

        $person1->setProperty('knows', $person2);

        $this->schemaManager->addType($person1, $person2);

        // ...
    }
}
