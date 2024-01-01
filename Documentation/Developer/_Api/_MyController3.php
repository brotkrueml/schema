<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use Brotkrueml\Schema\Type\TypeFactory;

final class MyController
{
    public function __construct(
        private readonly TypeFactory $typeFactory,
    ) {}

    public function doSomething(): void
    {
        // ...

        $event = $this->typeFactory->create('Event')
            ->setProperty('name', 'Fancy Event')
            ->setProperty('image', 'https:/example.org/event.png')
            ->setProperty('url', 'https://example.org/')
            ->setProperty('isAccessibleForFree', true)
            ->setProperty('sameAs', 'https://twitter.com/fancy-event')
            ->addProperty('sameAs', 'https://facebook.com/fancy-event')
        ;

        // ...
    }
}
