<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Model\Enumeration\GenderType;
use Brotkrueml\Schema\Type\TypeFactoryInterface;

final class MyController
{
    public function __construct(
        private readonly TypeFactoryInterface $typeFactory,
    ) {}

    public function doSomething(): void
    {
        // ...

        $person = $this->typeFactory->create('Person');
        $person
            ->setId('https://example.org/#person-42')
            ->setProperty('givenName', 'John')
            ->setProperty('familyName', 'Smith')
            ->setProperty('gender', GenderType::Male);

        // ...
    }
}
