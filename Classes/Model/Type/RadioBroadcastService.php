<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A delivery service through which radio content is provided via broadcast over the air or online.
 */
#[Type('RadioBroadcastService')]
final class RadioBroadcastService extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'aggregateRating',
        'alternateName',
        'areaServed',
        'audience',
        'availableChannel',
        'award',
        'brand',
        'broadcastAffiliateOf',
        'broadcastDisplayName',
        'broadcastFrequency',
        'broadcastTimezone',
        'broadcaster',
        'broker',
        'callSign',
        'category',
        'description',
        'disambiguatingDescription',
        'hasBroadcastChannel',
        'hasCertification',
        'hasOfferCatalog',
        'hoursAvailable',
        'identifier',
        'image',
        'inLanguage',
        'isRelatedTo',
        'isSimilarTo',
        'logo',
        'mainEntityOfPage',
        'name',
        'offers',
        'owner',
        'parentService',
        'potentialAction',
        'provider',
        'providerMobility',
        'review',
        'sameAs',
        'serviceOutput',
        'serviceType',
        'slogan',
        'subjectOf',
        'termsOfService',
        'url',
        'videoFormat',
    ];
}
