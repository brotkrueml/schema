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
 * The geographic shape of a place. A GeoShape can be described using several properties whose values are based on latitude/longitude pairs. Either whitespace or commas can be used to separate latitude and longitude; whitespace should be used when writing a list of several such points.
 */
final class GeoShape extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'address' => null,
        'addressCountry' => null,
        'alternateName' => null,
        'box' => null,
        'circle' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'elevation' => null,
        'identifier' => null,
        'image' => null,
        'line' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'polygon' => null,
        'postalCode' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
