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
 * Residence type: Single-family home.
 */
#[Type('SingleFamilyResidence')]
final class SingleFamilyResidence extends AbstractType
{
    protected static array $propertyNames = [
        'accommodationCategory',
        'accommodationFloorPlan',
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
        'floorLevel',
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
        'hasDriveThroughService',
        'hasGS1DigitalLink',
        'hasMap',
        'identifier',
        'image',
        'isAccessibleForFree',
        'isicV4',
        'keywords',
        'latitude',
        'leaseLength',
        'logo',
        'longitude',
        'mainEntityOfPage',
        'maximumAttendeeCapacity',
        'name',
        'numberOfBathroomsTotal',
        'numberOfBedrooms',
        'numberOfFullBathrooms',
        'numberOfPartialBathrooms',
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
        'tourBookingPage',
        'url',
        'yearBuilt',
    ];
}
