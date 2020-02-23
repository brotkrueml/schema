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
 * Organization: A business corporation.
 */
final class Corporation extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'address' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'alumni' => null,
        'areaServed' => null,
        'award' => null,
        'brand' => null,
        'contactPoint' => null,
        'department' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'dissolutionDate' => null,
        'duns' => null,
        'email' => null,
        'employee' => null,
        'event' => null,
        'faxNumber' => null,
        'founder' => null,
        'foundingDate' => null,
        'foundingLocation' => null,
        'funder' => null,
        'globalLocationNumber' => null,
        'hasOfferCatalog' => null,
        'hasPOS' => null,
        'identifier' => null,
        'image' => null,
        'interactionStatistic' => null,
        'isicV4' => null,
        'legalName' => null,
        'leiCode' => null,
        'location' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'makesOffer' => null,
        'member' => null,
        'memberOf' => null,
        'naics' => null,
        'name' => null,
        'numberOfEmployees' => null,
        'owns' => null,
        'parentOrganization' => null,
        'potentialAction' => null,
        'publishingPrinciples' => null,
        'review' => null,
        'sameAs' => null,
        'seeks' => null,
        'slogan' => null,
        'sponsor' => null,
        'subOrganization' => null,
        'subjectOf' => null,
        'taxID' => null,
        'telephone' => null,
        'tickerSymbol' => null,
        'url' => null,
        'vatID' => null,
    ];
}
