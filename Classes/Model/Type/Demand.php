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
 * A demand entity represents the public, not necessarily binding, not necessarily exclusive, announcement by an organization or person to seek a certain type of goods or services. For describing demand using this type, the very same properties used for Offer apply.
 *
 * schema.org version 3.6
 */
class Demand extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('acceptedPaymentMethod', 'advanceBookingRequirement', 'areaServed', 'availability', 'availabilityEnds', 'availabilityStarts', 'availableAtOrFrom', 'availableDeliveryMethod', 'businessFunction', 'deliveryLeadTime', 'eligibleCustomerType', 'eligibleDuration', 'eligibleQuantity', 'eligibleRegion', 'eligibleTransactionVolume', 'gtin12', 'gtin13', 'gtin14', 'gtin8', 'includesObject', 'ineligibleRegion', 'inventoryLevel', 'itemCondition', 'itemOffered', 'mpn', 'priceSpecification', 'seller', 'serialNumber', 'sku', 'validFrom', 'validThrough', 'warranty');
    }
}
