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
 * A LegalService is a business that provides legally-oriented services, advice and representation, e.g. law firms.
 *
 * As a LocalBusiness it can be described as a provider of one or more Service\(s).
 */
final class LegalService extends AbstractType
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
        'currenciesAccepted',
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
        'paymentAccepted',
        'photo',
        'potentialAction',
        'priceRange',
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
