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
 * A particular physical business or branch of an organization. Examples of LocalBusiness include a restaurant, a particular branch of a restaurant chain, a branch of a bank, a medical practice, a club, a bowling alley, etc.
 *
 * schema.org version 3.6
 */
class LocalBusiness extends Place
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('alumni', 'areaServed', 'award', 'brand', 'contactPoint', 'currenciesAccepted', 'department', 'dissolutionDate', 'duns', 'email', 'employee', 'founder', 'foundingDate', 'foundingLocation', 'funder', 'hasOfferCatalog', 'hasPOS', 'legalName', 'leiCode', 'location', 'makesOffer', 'member', 'memberOf', 'naics', 'numberOfEmployees', 'openingHours', 'owns', 'parentOrganization', 'paymentAccepted', 'priceRange', 'publishingPrinciples', 'seeks', 'sponsor', 'subOrganization', 'taxID', 'vatID');
    }
}
