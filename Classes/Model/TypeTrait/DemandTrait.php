<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

trait DemandTrait
{
    protected $acceptedPaymentMethod;
    protected $advanceBookingRequirement;
    protected $areaServed;
    protected $availability;
    protected $availabilityEnds;
    protected $availabilityStarts;
    protected $availableAtOrFrom;
    protected $availableDeliveryMethod;
    protected $businessFunction;
    protected $deliveryLeadTime;
    protected $eligibleCustomerType;
    protected $eligibleDuration;
    protected $eligibleQuantity;
    protected $eligibleRegion;
    protected $eligibleTransactionVolume;
    protected $gtin12;
    protected $gtin13;
    protected $gtin14;
    protected $gtin8;
    protected $includesObject;
    protected $ineligibleRegion;
    protected $inventoryLevel;
    protected $itemCondition;
    protected $itemOffered;
    protected $mpn;
    protected $priceSpecification;
    protected $seller;
    protected $serialNumber;
    protected $sku;
    protected $validFrom;
    protected $validThrough;
    protected $warranty;
}
