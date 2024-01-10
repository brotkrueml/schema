<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * A kind of lodging business that focuses on renting single properties for limited time.
 */
#[Type('VacationRental')]
#[Manual(Publisher::Google, 'https://developers.google.com/search/docs/appearance/structured-data/vacation-rental')]
final class VacationRental extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
        'additionalType',
        'address',
        'aggregateRating',
        'alternateName',
        'alumni',
        'amenityFeature',
        'areaServed',
        'audience',
        'availableLanguage',
        'award',
        'branchCode',
        'brand',
        'checkinTime',
        'checkoutTime',
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
        'keywords',
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
        'numberOfRooms',
        'openingHours',
        'openingHoursSpecification',
        'owns',
        'parentOrganization',
        'paymentAccepted',
        'petsAllowed',
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
        'starRating',
        'subOrganization',
        'subjectOf',
        'taxID',
        'telephone',
        'url',
        'vatID',
    ];
}
