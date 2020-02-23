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
        'geoMidpoint' => null,
        'geoRadius' => null,
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
