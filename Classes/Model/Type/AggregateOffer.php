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
 * When a single product is associated with multiple offers (for example, the same pair of shoes is offered by different merchants), then AggregateOffer can be used.
 *
 * Note: AggregateOffers are normally expected to associate multiple offers that all share the same defined businessFunction value, or default to http://purl.org/goodrelations/v1#Sell if businessFunction is not explicitly defined.
 */
#[Type('AggregateOffer')]
#[Manual(Publisher::Google, 'Product snippet: Shopping aggregator page', 'https://developers.google.com/search/docs/appearance/structured-data/product-snippet#shopping-aggregator-page-example')]
final class AggregateOffer extends AbstractType
{
    protected static array $propertyNames = [
        'acceptedPaymentMethod',
        'addOn',
        'additionalProperty',
        'additionalType',
        'advanceBookingRequirement',
        'aggregateRating',
        'alternateName',
        'areaServed',
        'availability',
        'availabilityEnds',
        'availabilityStarts',
        'availableAtOrFrom',
        'availableDeliveryMethod',
        'businessFunction',
        'category',
        'deliveryLeadTime',
        'description',
        'disambiguatingDescription',
        'eligibleCustomerType',
        'eligibleDuration',
        'eligibleQuantity',
        'eligibleRegion',
        'eligibleTransactionVolume',
        'gtin12',
        'gtin13',
        'gtin14',
        'gtin8',
        'highPrice',
        'identifier',
        'image',
        'includesObject',
        'inventoryLevel',
        'isFamilyFriendly',
        'itemCondition',
        'itemOffered',
        'lowPrice',
        'mainEntityOfPage',
        'mpn',
        'name',
        'offerCount',
        'offeredBy',
        'offers',
        'potentialAction',
        'price',
        'priceCurrency',
        'priceSpecification',
        'priceValidUntil',
        'review',
        'sameAs',
        'seller',
        'serialNumber',
        'shippingDetails',
        'sku',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
        'warranty',
    ];
}
