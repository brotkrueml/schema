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
use Brotkrueml\Schema\Manual\Publisher;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A person (alive, dead, undead, or fictional).
 */
#[Type('Person')]
#[Manual(Publisher::Google, 'Profile page', 'https://developers.google.com/search/docs/appearance/structured-data/profile-page')]
final class Person extends AbstractType
{
    protected static array $propertyNames = [
        'additionalName',
        'additionalType',
        'address',
        'affiliation',
        'agentInteractionStatistic',
        'alternateName',
        'alumniOf',
        'award',
        'birthDate',
        'birthPlace',
        'brand',
        'callSign',
        'children',
        'colleague',
        'contactPoint',
        'deathDate',
        'deathPlace',
        'description',
        'disambiguatingDescription',
        'duns',
        'email',
        'familyName',
        'faxNumber',
        'follows',
        'funder',
        'funding',
        'gender',
        'givenName',
        'globalLocationNumber',
        'hasCertification',
        'hasCredential',
        'hasOccupation',
        'hasOfferCatalog',
        'hasPOS',
        'height',
        'homeLocation',
        'honorificPrefix',
        'honorificSuffix',
        'identifier',
        'image',
        'interactionStatistic',
        'isicV4',
        'jobTitle',
        'knows',
        'knowsAbout',
        'knowsLanguage',
        'mainEntityOfPage',
        'makesOffer',
        'memberOf',
        'naics',
        'name',
        'nationality',
        'netWorth',
        'owner',
        'owns',
        'parent',
        'performerIn',
        'potentialAction',
        'publishingPrinciples',
        'relatedTo',
        'sameAs',
        'seeks',
        'sibling',
        'skills',
        'sponsor',
        'spouse',
        'subjectOf',
        'taxID',
        'telephone',
        'url',
        'vatID',
        'weight',
        'workLocation',
        'worksFor',
    ];
}
