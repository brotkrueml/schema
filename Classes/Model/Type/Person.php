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
    protected $properties = [
        'additionalName' => null,
        'additionalType' => null,
        'address' => null,
        'affiliation' => null,
        'alternateName' => null,
        'alumniOf' => null,
        'award' => null,
        'birthDate' => null,
        'birthPlace' => null,
        'brand' => null,
        'children' => null,
        'colleague' => null,
        'contactPoint' => null,
        'deathDate' => null,
        'deathPlace' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'duns' => null,
        'email' => null,
        'familyName' => null,
        'faxNumber' => null,
        'follows' => null,
        'funder' => null,
        'givenName' => null,
        'globalLocationNumber' => null,
        'hasOccupation' => null,
        'hasOfferCatalog' => null,
        'hasPOS' => null,
        'height' => null,
        'homeLocation' => null,
        'honorificPrefix' => null,
        'honorificSuffix' => null,
        'identifier' => null,
        'image' => null,
        'interactionStatistic' => null,
        'isicV4' => null,
        'knows' => null,
        'mainEntityOfPage' => null,
        'makesOffer' => null,
        'memberOf' => null,
        'naics' => null,
        'name' => null,
        'nationality' => null,
        'netWorth' => null,
        'owns' => null,
        'parent' => null,
        'performerIn' => null,
        'potentialAction' => null,
        'publishingPrinciples' => null,
        'relatedTo' => null,
        'sameAs' => null,
        'seeks' => null,
        'sibling' => null,
        'sponsor' => null,
        'spouse' => null,
        'subjectOf' => null,
        'taxID' => null,
        'telephone' => null,
        'url' => null,
        'vatID' => null,
        'weight' => null,
        'workLocation' => null,
        'worksFor' => null,
    ];
}
