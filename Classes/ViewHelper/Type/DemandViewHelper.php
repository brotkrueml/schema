<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A demand entity represents the public, not necessarily binding, not necessarily exclusive, announcement by an organization or person to seek a certain type of goods or services. For describing demand using this type, the very same properties used for Offer apply.
 *
 * schema.org version 3.6
 */
class DemandViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('acceptedPaymentMethod', 'mixed', 'The payment method(s) accepted by seller for this offer.');
        $this->registerArgument('advanceBookingRequirement', 'mixed', 'The amount of time that is required between accepting the offer and the actual usage of the resource or service.');
        $this->registerArgument('areaServed', 'mixed', 'The geographic area where a service or offered item is provided.');
        $this->registerArgument('availability', 'mixed', 'The availability of this item&#x2014;for example In stock, Out of stock, Pre-order, etc.');
        $this->registerArgument('availabilityEnds', 'mixed', 'The end of the availability of the product or service included in the offer.');
        $this->registerArgument('availabilityStarts', 'mixed', 'The beginning of the availability of the product or service included in the offer.');
        $this->registerArgument('availableAtOrFrom', 'mixed', 'The place(s) from which the offer can be obtained (e.g. store locations).');
        $this->registerArgument('availableDeliveryMethod', 'mixed', 'The delivery method(s) available for this offer.');
        $this->registerArgument('businessFunction', 'mixed', 'The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.');
        $this->registerArgument('deliveryLeadTime', 'mixed', 'The typical delay between the receipt of the order and the goods either leaving the warehouse or being prepared for pickup, in case the delivery method is on site pickup.');
        $this->registerArgument('eligibleCustomerType', 'mixed', 'The type(s) of customers for which the given offer is valid.');
        $this->registerArgument('eligibleDuration', 'mixed', 'The duration for which the given offer is valid.');
        $this->registerArgument('eligibleQuantity', 'mixed', 'The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.');
        $this->registerArgument('eligibleRegion', 'mixed', 'The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, the place, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is valid.');
        $this->registerArgument('eligibleTransactionVolume', 'mixed', 'The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.');
        $this->registerArgument('gtin12', 'mixed', 'The GTIN-12 code of the product, or the product to which the offer refers. The GTIN-12 is the 12-digit GS1 Identification Key composed of a U.P.C. Company Prefix, Item Reference, and Check Digit used to identify trade items. See GS1 GTIN Summary for more details.');
        $this->registerArgument('gtin13', 'mixed', 'The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero. See GS1 GTIN Summary for more details.');
        $this->registerArgument('gtin14', 'mixed', 'The GTIN-14 code of the product, or the product to which the offer refers. See GS1 GTIN Summary for more details.');
        $this->registerArgument('gtin8', 'mixed', 'The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN. See GS1 GTIN Summary for more details.');
        $this->registerArgument('includesObject', 'mixed', 'This links to a node or nodes indicating the exact quantity of the products included in the offer.');
        $this->registerArgument('ineligibleRegion', 'mixed', 'The ISO 3166-1 (ISO 3166-1 alpha-2) or ISO 3166-2 code, the place, or the GeoShape for the geo-political region(s) for which the offer or delivery charge specification is not valid, e.g. a region where the transaction is not allowed.');
        $this->registerArgument('inventoryLevel', 'mixed', 'The current approximate inventory level for the item or items.');
        $this->registerArgument('itemCondition', 'mixed', 'A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.');
        $this->registerArgument('itemOffered', 'mixed', 'The item being offered.');
        $this->registerArgument('mpn', 'mixed', 'The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.');
        $this->registerArgument('priceSpecification', 'mixed', 'One or more detailed price specifications, indicating the unit price and delivery or payment charges.');
        $this->registerArgument('seller', 'mixed', 'An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.');
        $this->registerArgument('serialNumber', 'mixed', 'The serial number or any alphanumeric identifier of a particular product. When attached to an offer, it is a shortcut for the serial number of the product included in the offer.');
        $this->registerArgument('sku', 'mixed', 'The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.');
        $this->registerArgument('validFrom', 'mixed', 'The date when the item becomes valid.');
        $this->registerArgument('validThrough', 'mixed', 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.');
        $this->registerArgument('warranty', 'mixed', 'The warranty promise(s) included in the offer.');
    }
}
