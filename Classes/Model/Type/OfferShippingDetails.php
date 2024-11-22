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
 * OfferShippingDetails represents information about shipping destinations.
 *
 * Multiple of these entities can be used to represent different shipping rates for different destinations:
 *
 * One entity for Alaska/Hawaii. A different one for continental US. A different one for all France.
 *
 * Multiple of these entities can be used to represent different shipping costs and delivery times.
 *
 * Two entities that are identical but differ in rate and time:
 *
 * E.g. Cheaper and slower: $5 in 5-7 days
 * or Fast and expensive: $15 in 1-2 days.
 */
#[Type('OfferShippingDetails')]
final class OfferShippingDetails extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'deliveryTime',
        'depth',
        'description',
        'disambiguatingDescription',
        'doesNotShip',
        'height',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'shippingDestination',
        'shippingLabel',
        'shippingOrigin',
        'shippingRate',
        'shippingSettingsLink',
        'subjectOf',
        'transitTimeLabel',
        'url',
        'validForMemberTier',
        'weight',
        'width',
    ];
}
