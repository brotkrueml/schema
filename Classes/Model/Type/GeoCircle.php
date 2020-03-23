<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A GeoCircle is a GeoShape representing a circular geographic area. As it is a GeoShape
 */
final class GeoCircle extends AbstractType
{
    protected static $propertyNames = [
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
