<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * An elementary school.
 */
final class ElementarySchool extends AbstractType
{
    protected static $propertyNames = [
        'additionalProperty',
        'additionalType',
        'address',
        'aggregateRating',
        'alternateName',
        'alumni',
        'amenityFeature',
        'areaServed',
        'award',
        'branchCode',
        'brand',
        'contactPoint',
        'containedInPlace',
        'containsPlace',
        'department',
        'description',
        'disambiguatingDescription',
        'dissolutionDate',
        'duns',
        'email',
        'employee',
        'event',
        'faxNumber',
        'founder',
        'foundingDate',
        'foundingLocation',
        'funder',
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
        'hasMap',
        'hasOfferCatalog',
        'hasPOS',
        'identifier',
        'image',
        'interactionStatistic',
        'isAccessibleForFree',
        'isicV4',
        'latitude',
        'legalName',
        'leiCode',
        'location',
        'logo',
        'longitude',
        'mainEntityOfPage',
        'makesOffer',
        'maximumAttendeeCapacity',
        'member',
        'memberOf',
        'naics',
        'name',
        'numberOfEmployees',
        'openingHours',
        'openingHoursSpecification',
        'owns',
        'parentOrganization',
        'photo',
        'potentialAction',
        'publicAccess',
        'publishingPrinciples',
        'review',
        'sameAs',
        'seeks',
        'slogan',
        'smokingAllowed',
        'specialOpeningHoursSpecification',
        'sponsor',
        'subOrganization',
        'subjectOf',
        'taxID',
        'telephone',
        'url',
        'vatID',
    ];
}
