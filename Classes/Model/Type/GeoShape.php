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
 * The geographic shape of a place. A GeoShape can be described using several properties whose values are based on latitude/longitude pairs. Either whitespace or commas can be used to separate latitude and longitude; whitespace should be used when writing a list of several such points.
 */
#[Type('GeoShape')]
final class GeoShape extends AbstractType
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
