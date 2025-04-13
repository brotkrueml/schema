<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

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
#[Manual(Publisher::Google, 'Merchant listing: Shipping details', 'https://developers.google.com/search/docs/appearance/structured-data/merchant-listing#product-with-shipping-example')]
final class OfferShippingDetails extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'deliveryTime',
        'description',
        'disambiguatingDescription',
        'doesNotShip',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'shippingDestination',
        'shippingOrigin',
        'shippingRate',
        'subjectOf',
        'url',
    ];
}
