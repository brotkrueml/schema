<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A person (alive, dead, undead, or fictional).
 *
 * schema.org version 3.6
 */
class Person extends Thing
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('additionalName', 'address', 'affiliation', 'alumniOf', 'award', 'birthDate', 'birthPlace', 'brand', 'children', 'colleague', 'contactPoint', 'deathDate', 'deathPlace', 'duns', 'email', 'familyName', 'faxNumber', 'follows', 'funder', 'gender', 'givenName', 'globalLocationNumber', 'hasOccupation', 'hasOfferCatalog', 'hasPOS', 'height', 'homeLocation', 'honorificPrefix', 'honorificSuffix', 'isicV4', 'jobTitle', 'knows', 'makesOffer', 'memberOf', 'naics', 'nationality', 'netWorth', 'owns', 'parent', 'performerIn', 'publishingPrinciples', 'relatedTo', 'seeks', 'sibling', 'sponsor', 'spouse', 'taxID', 'telephone', 'vatID', 'weight', 'workLocation', 'worksFor');
    }
}
