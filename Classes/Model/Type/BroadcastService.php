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
 * A delivery service through which content is provided via broadcast over the air or online.
 */
final class BroadcastService extends AbstractType
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
        'broadcastAffiliateOf' => null,
        'broadcastDisplayName' => null,
        'broadcastFrequency' => null,
        'broadcastTimezone' => null,
        'broadcaster' => null,
        'broker' => null,
        'category' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'hasBroadcastChannel' => null,
        'hasOfferCatalog' => null,
        'hoursAvailable' => null,
        'identifier' => null,
        'image' => null,
        'inLanguage' => null,
        'isRelatedTo' => null,
        'isSimilarTo' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'offers' => null,
        'parentService' => null,
        'potentialAction' => null,
        'provider' => null,
        'providerMobility' => null,
        'review' => null,
        'sameAs' => null,
        'serviceOutput' => null,
        'serviceType' => null,
        'slogan' => null,
        'subjectOf' => null,
        'url' => null,
        'videoFormat' => null,
    ];
}
