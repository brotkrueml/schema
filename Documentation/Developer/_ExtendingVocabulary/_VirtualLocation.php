<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Schema\Type;

use Brotkrueml\Schema\Attributes\Type;

#[Type('VirtualLocation')]
final class VirtualLocation
{
    private static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
