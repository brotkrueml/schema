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
        'alternateName',
        'alumniOf',
        'award',
        'birthDate',
        'birthPlace',
        'brand',
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
        'givenName',
        'globalLocationNumber',
        'hasCertification',
        'hasOccupation',
        'hasOfferCatalog',
        'hasPOS',
        'homeLocation',
        'honorificPrefix',
        'honorificSuffix',
        'identifier',
        'image',
        'interactionStatistic',
        'isicV4',
        'knows',
        'mainEntityOfPage',
        'makesOffer',
        'memberOf',
        'naics',
        'name',
        'nationality',
        'netWorth',
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
        'workLocation',
        'worksFor',
    ];
}
