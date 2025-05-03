<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Schema\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

#[Type('VirtualLocation')]
final class VirtualLocation extends AbstractType
{
    protected static array $propertyNames = [
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
