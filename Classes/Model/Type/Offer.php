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
 * An offer to transfer some rights to an item or to provide a service — for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
 */
final class Offer extends AbstractType
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
        'identifier' => null,
        'image' => null,
        'includesObject' => null,
        'inventoryLevel' => null,
        'itemCondition' => null,
        'itemOffered' => null,
        'mainEntityOfPage' => null,
        'mpn' => null,
        'name' => null,
        'offeredBy' => null,
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
