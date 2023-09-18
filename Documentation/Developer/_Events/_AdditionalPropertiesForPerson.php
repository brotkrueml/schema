<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Model\Type\Person;

final class AdditionalPropertiesForPerson
{
    public function __invoke(RegisterAdditionalTypePropertiesEvent $event): void
    {
        if ($event->getType() === Person::class) {
            $event->registerAdditionalProperty('gender');
            $event->registerAdditionalProperty('jobTitle');
        }
    }
}
