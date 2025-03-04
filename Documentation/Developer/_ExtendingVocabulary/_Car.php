<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Schema\AdditionalProperties;

use Brotkrueml\Schema\Core\AdditionalPropertiesInterface;

final class Car implements AdditionalPropertiesInterface
{
    public function getType(): string
    {
        return 'Car';
    }

    public function getAdditionalProperties(): array
    {
        return [
            'accelerationTime',
            'emissionsCO2',
            'fuelCapacity',
            'seatingCapacity',
            'speed',
        ];
    }
}
