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
 * A particular physical business or branch of an organization. Examples of LocalBusiness include a restaurant, a particular branch of a restaurant chain, a branch of a bank, a medical practice, a club, a bowling alley, etc.
 */
#[Type('LocalBusiness')]
#[Manual(Publisher::Google, 'Local business', 'https://developers.google.com/search/docs/appearance/structured-data/local-business')]
final class LocalBusiness extends AbstractType
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
