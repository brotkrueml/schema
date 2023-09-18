<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly TypeFactory $typeFactory,
    ) {
    }

    public function doSomething(): void
    {
        // ...

        $person = $this->typeFactory->create('Person');
        $person
            ->setId('https://example.org/#person-42')
            ->setProperty('givenName', 'John')
            ->setProperty('familyName', 'Smith')
            ->setProperty('gender', 'https://schema.org/Male');

        // ...
    }
}
