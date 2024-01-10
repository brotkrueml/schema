<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A GeoCircle is a GeoShape representing a circular geographic area. As it is a GeoShape
 * The center of the circle can be indicated via the 'geoMidpoint' property, or more approximately using 'address', 'postalCode'.
 */
#[Type('GeoCircle')]
final class GeoCircle extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'address',
        'addressCountry',
        'alternateName',
        'box',
        'circle',
        'description',
        'disambiguatingDescription',
        'elevation',
        'geoMidpoint',
        'geoRadius',
        'identifier',
        'image',
        'line',
        'mainEntityOfPage',
        'name',
        'polygon',
        'postalCode',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
