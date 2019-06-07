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
 * An organization such as a school, NGO, corporation, club, etc.
 *
 * schema.org version 3.6
 */
class Organization extends Thing
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('address', 'aggregateRating', 'alumni', 'areaServed', 'award', 'brand', 'contactPoint', 'department', 'dissolutionDate', 'duns', 'email', 'employee', 'event', 'faxNumber', 'founder', 'foundingDate', 'foundingLocation', 'funder', 'globalLocationNumber', 'hasOfferCatalog', 'hasPOS', 'isicV4', 'legalName', 'leiCode', 'location', 'logo', 'makesOffer', 'member', 'memberOf', 'naics', 'numberOfEmployees', 'owns', 'parentOrganization', 'publishingPrinciples', 'review', 'seeks', 'slogan', 'sponsor', 'subOrganization', 'taxID', 'telephone', 'vatID');
    }
}
