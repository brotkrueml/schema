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
 * A dentist.
 *
 * schema.org version 3.6
 */
class Dentist extends MedicalOrganization
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('alumni', 'areaServed', 'award', 'brand', 'contactPoint', 'currenciesAccepted', 'department', 'dissolutionDate', 'duns', 'email', 'employee', 'founder', 'foundingDate', 'foundingLocation', 'funder', 'hasOfferCatalog', 'hasPOS', 'legalName', 'leiCode', 'location', 'makesOffer', 'member', 'memberOf', 'naics', 'numberOfEmployees', 'openingHours', 'owns', 'parentOrganization', 'paymentAccepted', 'priceRange', 'publishingPrinciples', 'seeks', 'sponsor', 'subOrganization', 'taxID', 'vatID');
    }
}
