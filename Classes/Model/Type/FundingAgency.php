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
 * A FundingAgency is an organization that implements one or more FundingSchemes and manages
 * the granting process (via Grants, typically MonetaryGrants).
 * A funding agency is not always required for grant funding, e.g. philanthropic giving, corporate sponsorship etc.
 *
 * Examples of funding agencies include ERC, REA, NIH, Bill and Melinda Gates Foundation, ...
 */
#[Type('FundingAgency')]
final class FundingAgency extends AbstractType
{
    protected static array $propertyNames = [
        'acceptedPaymentMethod',
        'actionableFeedbackPolicy',
        'additionalType',
        'address',
        'agentInteractionStatistic',
        'aggregateRating',
        'alternateName',
        'alumni',
        'areaServed',
        'award',
        'brand',
        'companyRegistration',
        'contactPoint',
        'correctionsPolicy',
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
        'founder',
        'foundingDate',
        'foundingLocation',
        'funder',
        'funding',
        'globalLocationNumber',
        'hasCertification',
        'hasCredential',
        'hasGS1DigitalLink',
        'hasMemberProgram',
        'hasMerchantReturnPolicy',
        'hasOfferCatalog',
        'hasPOS',
        'hasShippingService',
        'identifier',
        'image',
        'interactionStatistic',
        'isicV4',
        'iso6523Code',
        'keywords',
        'knowsAbout',
        'knowsLanguage',
        'legalAddress',
        'legalName',
        'legalRepresentative',
        'leiCode',
        'location',
        'logo',
        'mainEntityOfPage',
        'makesOffer',
        'member',
        'memberOf',
        'naics',
        'name',
        'nonprofitStatus',
        'numberOfEmployees',
        'owner',
        'ownershipFundingInfo',
        'owns',
        'parentOrganization',
        'potentialAction',
        'publishingPrinciples',
        'review',
        'sameAs',
        'seeks',
        'skills',
        'slogan',
        'sponsor',
        'subOrganization',
        'subjectOf',
        'taxID',
        'telephone',
        'unnamedSourcesPolicy',
        'url',
        'vatID',
    ];
}
