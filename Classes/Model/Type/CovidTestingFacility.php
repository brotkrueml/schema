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
 * A CovidTestingFacility is a MedicalClinic where testing for the COVID-19 Coronavirus
 * disease is available. If the facility is being made available from an established Pharmacy, Hotel, or other
 * non-medical organization, multiple types can be listed. This makes it easier to re-use existing schema.org information
 * about that place, e.g. contact info, address, opening hours. Note that in an emergency, such information may not always be reliable.
 */
#[Type('CovidTestingFacility')]
final class CovidTestingFacility extends AbstractType
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
        'award',
        'branchCode',
        'brand',
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
        'openingHours',
        'openingHoursSpecification',
        'owner',
        'ownershipFundingInfo',
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
        'skills',
        'slogan',
        'smokingAllowed',
        'specialOpeningHoursSpecification',
        'sponsor',
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
