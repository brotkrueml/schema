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
 * A hotel room is a single room in a hotel.
 *
 * See also the <a href="https://schema.org/docs/hotels.html">dedicated document on the use of schema.org for marking up hotels and other forms of accommodations</a>.
 */
#[Type('HotelRoom')]
final class HotelRoom extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
        'additionalType',
        'address',
        'aggregateRating',
        'alternateName',
        'amenityFeature',
        'bed',
        'branchCode',
        'containedInPlace',
        'containsPlace',
        'description',
        'disambiguatingDescription',
        'event',
        'faxNumber',
        'floorSize',
        'geo',
        'geoContains',
        'geoCoveredBy',
        'geoCovers',
        'geoCrosses',
        'geoDisjoint',
        'geoEquals',
        'geoIntersects',
        'geoOverlaps',
        'geoTouches',
        'geoWithin',
        'globalLocationNumber',
        'hasCertification',
        'hasMap',
        'identifier',
        'image',
        'isAccessibleForFree',
        'isicV4',
        'keywords',
        'latitude',
        'logo',
        'longitude',
        'mainEntityOfPage',
        'maximumAttendeeCapacity',
        'name',
        'numberOfRooms',
        'occupancy',
        'openingHoursSpecification',
        'owner',
        'permittedUsage',
        'petsAllowed',
        'photo',
        'potentialAction',
        'publicAccess',
        'review',
        'sameAs',
        'slogan',
        'smokingAllowed',
        'specialOpeningHoursSpecification',
        'subjectOf',
        'telephone',
        'url',
    ];
}
