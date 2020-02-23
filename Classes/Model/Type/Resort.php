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
 * A resort is a place used for relaxation or recreation, attracting visitors for holidays or vacations. Resorts are places, towns or sometimes commercial establishment operated by a single company (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Resort).
 */
final class Resort extends AbstractType
{
    protected $properties = [
        'additionalProperty' => null,
        'additionalType' => null,
        'address' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'alumni' => null,
        'amenityFeature' => null,
        'areaServed' => null,
        'audience' => null,
        'availableLanguage' => null,
        'award' => null,
        'branchCode' => null,
        'brand' => null,
        'checkinTime' => null,
        'checkoutTime' => null,
        'contactPoint' => null,
        'containedInPlace' => null,
        'containsPlace' => null,
        'currenciesAccepted' => null,
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
        'geo' => null,
        'geoContains' => null,
        'geoCoveredBy' => null,
        'geoCovers' => null,
        'geoCrosses' => null,
        'geoDisjoint' => null,
        'geoEquals' => null,
        'geoIntersects' => null,
        'geoOverlaps' => null,
        'geoTouches' => null,
        'geoWithin' => null,
        'globalLocationNumber' => null,
        'hasMap' => null,
        'hasOfferCatalog' => null,
        'hasPOS' => null,
        'identifier' => null,
        'image' => null,
        'interactionStatistic' => null,
        'isAccessibleForFree' => null,
        'isicV4' => null,
        'latitude' => null,
        'legalName' => null,
        'leiCode' => null,
        'location' => null,
        'logo' => null,
        'longitude' => null,
        'mainEntityOfPage' => null,
        'makesOffer' => null,
        'maximumAttendeeCapacity' => null,
        'member' => null,
        'memberOf' => null,
        'naics' => null,
        'name' => null,
        'numberOfEmployees' => null,
        'numberOfRooms' => null,
        'openingHours' => null,
        'openingHoursSpecification' => null,
        'owns' => null,
        'parentOrganization' => null,
        'paymentAccepted' => null,
        'petsAllowed' => null,
        'photo' => null,
        'potentialAction' => null,
        'priceRange' => null,
        'publicAccess' => null,
        'publishingPrinciples' => null,
        'review' => null,
        'sameAs' => null,
        'seeks' => null,
        'slogan' => null,
        'smokingAllowed' => null,
        'specialOpeningHoursSpecification' => null,
        'sponsor' => null,
        'starRating' => null,
        'subOrganization' => null,
        'subjectOf' => null,
        'taxID' => null,
        'telephone' => null,
        'url' => null,
        'vatID' => null,
    ];
}
