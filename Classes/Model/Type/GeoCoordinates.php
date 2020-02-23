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
 * The geographic coordinates of a place or event.
 */
final class GeoCoordinates extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'address' => null,
        'addressCountry' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'elevation' => null,
        'identifier' => null,
        'image' => null,
        'latitude' => null,
        'longitude' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'postalCode' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
