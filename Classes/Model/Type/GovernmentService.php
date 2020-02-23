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
 * A service provided by a government organization, e.g. food stamps, veterans benefits, etc.
 */
final class GovernmentService extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'areaServed' => null,
        'audience' => null,
        'availableChannel' => null,
        'award' => null,
        'brand' => null,
        'broker' => null,
        'category' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'hasOfferCatalog' => null,
        'hoursAvailable' => null,
        'identifier' => null,
        'image' => null,
        'isRelatedTo' => null,
        'isSimilarTo' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'offers' => null,
        'potentialAction' => null,
        'provider' => null,
        'providerMobility' => null,
        'review' => null,
        'sameAs' => null,
        'serviceOperator' => null,
        'serviceOutput' => null,
        'serviceType' => null,
        'slogan' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
