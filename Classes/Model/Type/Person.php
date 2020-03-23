<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A person (alive, dead, undead, or fictional).
 */
final class Person extends AbstractType
{
    protected static $propertyNames = [
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
