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
 * A camping site, campsite, or Campground is a place used for overnight stay in the outdoors, typically containing individual CampingPitch locations.
 *
 * In British English a campsite is an area, usually divided into a number of pitches, where people can camp overnight using tents or camper vans or caravans; this British English use of the word is synonymous with the American English expression campground. In American English the term campsite generally means an area where an individual, family, group, or military unit can pitch a tent or park a camper; a campground may contain many campsites (source: Wikipedia, see [https://en.wikipedia.org/wiki/Campsite](https://en.wikipedia.org/wiki/Campsite)).
 *
 *
 *
 * See also the dedicated [document on the use of schema.org for marking up hotels and other forms of accommodations](/docs/hotels.html).
 */
#[Type('Campground')]
final class Campground extends AbstractType
{
    protected static array $propertyNames = [
        'acceptedPaymentMethod',
        'actionableFeedbackPolicy',
        'additionalProperty',
        'additionalType',
        'address',
        'agentInteractionStatistic',
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
        'companyRegistration',
        'contactPoint',
        'containedInPlace',
        'containsPlace',
        'correctionsPolicy',
        'currenciesAccepted',
        'department',
        'description',
        'disambiguatingDescription',
        'dissolutionDate',
        'diversityPolicy',
        'diversityStaffingReport',
        'duns',
        'email',
        'employee',
        'ethicsPolicy',
        'event',
        'faxNumber',
        'floorLevel',
        'founder',
        'foundingDate',
        'foundingLocation',
        'funder',
        'funding',
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
        'hasCredential',
        'hasDriveThroughService',
        'hasGS1DigitalLink',
        'hasMap',
        'hasMemberProgram',
        'hasMerchantReturnPolicy',
        'hasOfferCatalog',
        'hasPOS',
        'hasShippingService',
        'identifier',
        'image',
        'interactionStatistic',
        'isAccessibleForFree',
        'isicV4',
        'iso6523Code',
        'keywords',
        'knowsAbout',
        'knowsLanguage',
        'latitude',
        'legalAddress',
        'legalName',
        'legalRepresentative',
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
        'nonprofitStatus',
        'numberOfEmployees',
        'numberOfRooms',
        'openingHours',
        'openingHoursSpecification',
        'owner',
        'ownershipFundingInfo',
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
        'skills',
        'slogan',
        'smokingAllowed',
        'specialOpeningHoursSpecification',
        'sponsor',
        'starRating',
        'subOrganization',
        'subjectOf',
        'taxID',
        'telephone',
        'tourBookingPage',
        'unnamedSourcesPolicy',
        'url',
        'vatID',
    ];
}
