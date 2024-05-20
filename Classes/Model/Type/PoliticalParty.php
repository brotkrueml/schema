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
 * Organization: Political Party.
 */
#[Type('PoliticalParty')]
final class PoliticalParty extends AbstractType
{
    protected static array $propertyNames = [
        'acceptedPaymentMethod',
        'additionalType',
        'address',
        'aggregateRating',
        'alternateName',
        'alumni',
        'areaServed',
        'award',
        'brand',
        'contactPoint',
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
        'globalLocationNumber',
        'hasCertification',
        'hasOfferCatalog',
        'hasPOS',
        'identifier',
        'image',
        'interactionStatistic',
        'isicV4',
        'keywords',
        'legalName',
        'leiCode',
        'location',
        'logo',
        'mainEntityOfPage',
        'makesOffer',
        'member',
        'memberOf',
        'naics',
        'name',
        'numberOfEmployees',
        'owns',
        'parentOrganization',
        'potentialAction',
        'publishingPrinciples',
        'review',
        'sameAs',
        'seeks',
        'slogan',
        'sponsor',
        'subOrganization',
        'subjectOf',
        'taxID',
        'telephone',
        'url',
        'vatID',
    ];
}
