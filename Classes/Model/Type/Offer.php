<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * An offer to transfer some rights to an item or to provide a service — for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
 *
 * schema.org version 3.6
 */
class Offer extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('acceptedPaymentMethod', 'addOn', 'advanceBookingRequirement', 'aggregateRating', 'areaServed', 'availability', 'availabilityEnds', 'availabilityStarts', 'availableAtOrFrom', 'availableDeliveryMethod', 'businessFunction', 'category', 'deliveryLeadTime', 'eligibleCustomerType', 'eligibleDuration', 'eligibleQuantity', 'eligibleRegion', 'eligibleTransactionVolume', 'gtin12', 'gtin13', 'gtin14', 'gtin8', 'includesObject', 'ineligibleRegion', 'inventoryLevel', 'itemCondition', 'itemOffered', 'mpn', 'offeredBy', 'price', 'priceCurrency', 'priceSpecification', 'priceValidUntil', 'review', 'seller', 'serialNumber', 'sku', 'validFrom', 'validThrough', 'warranty');
    }
}
