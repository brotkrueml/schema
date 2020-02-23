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
 * When a single product is associated with multiple offers (for example, the same pair of shoes is offered by different merchants), then AggregateOffer can be used.
 */
final class AggregateOffer extends AbstractType
{
    protected $properties = [
        'acceptedPaymentMethod' => null,
        'addOn' => null,
        'additionalType' => null,
        'advanceBookingRequirement' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'areaServed' => null,
        'availability' => null,
        'availabilityEnds' => null,
        'availabilityStarts' => null,
        'availableAtOrFrom' => null,
        'availableDeliveryMethod' => null,
        'businessFunction' => null,
        'category' => null,
        'deliveryLeadTime' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'eligibleCustomerType' => null,
        'eligibleDuration' => null,
        'eligibleQuantity' => null,
        'eligibleRegion' => null,
        'eligibleTransactionVolume' => null,
        'gtin12' => null,
        'gtin13' => null,
        'gtin14' => null,
        'gtin8' => null,
        'highPrice' => null,
        'identifier' => null,
        'image' => null,
        'includesObject' => null,
        'inventoryLevel' => null,
        'itemCondition' => null,
        'itemOffered' => null,
        'lowPrice' => null,
        'mainEntityOfPage' => null,
        'mpn' => null,
        'name' => null,
        'offerCount' => null,
        'offeredBy' => null,
        'offers' => null,
        'potentialAction' => null,
        'price' => null,
        'priceCurrency' => null,
        'priceSpecification' => null,
        'priceValidUntil' => null,
        'review' => null,
        'sameAs' => null,
        'seller' => null,
        'serialNumber' => null,
        'sku' => null,
        'subjectOf' => null,
        'url' => null,
        'validFrom' => null,
        'validThrough' => null,
        'warranty' => null,
    ];
}
