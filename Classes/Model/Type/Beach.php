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
 * Beach.
 */
final class Beach extends AbstractType
{
    protected $properties = [
        'additionalProperty' => null,
        'additionalType' => null,
        'address' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'amenityFeature' => null,
        'branchCode' => null,
        'containedInPlace' => null,
        'containsPlace' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'event' => null,
        'faxNumber' => null,
        'geo' => null,
        'geoContains' => null,
        'geoCoveredBy' => null,
        'geoCovers' => null,
        'geoCrosses' => null,
        'geoDisjoint' => null,
        'geoEquals' => null,
        'geoIntersects' => null,
        'geoOverlaps' => null,
        'geoTouches' => null,
        'geoWithin' => null,
        'globalLocationNumber' => null,
        'hasMap' => null,
        'identifier' => null,
        'image' => null,
        'isAccessibleForFree' => null,
        'isicV4' => null,
        'latitude' => null,
        'logo' => null,
        'longitude' => null,
        'mainEntityOfPage' => null,
        'maximumAttendeeCapacity' => null,
        'name' => null,
        'openingHours' => null,
        'openingHoursSpecification' => null,
        'photo' => null,
        'potentialAction' => null,
        'publicAccess' => null,
        'review' => null,
        'sameAs' => null,
        'slogan' => null,
        'smokingAllowed' => null,
        'specialOpeningHoursSpecification' => null,
        'subjectOf' => null,
        'telephone' => null,
        'url' => null,
    ];
}
