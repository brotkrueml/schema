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
 * A demand entity represents the public, not necessarily binding, not necessarily exclusive, announcement by an organization or person to seek a certain type of goods or services. For describing demand using this type, the very same properties used for Offer apply.
 */
final class Demand extends AbstractType
{
    protected $properties = [
        'acceptedPaymentMethod' => null,
        'additionalType' => null,
        'advanceBookingRequirement' => null,
        'alternateName' => null,
        'areaServed' => null,
        'availability' => null,
        'availabilityEnds' => null,
        'availabilityStarts' => null,
        'availableAtOrFrom' => null,
        'availableDeliveryMethod' => null,
        'businessFunction' => null,
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
        'potentialAction' => null,
        'priceSpecification' => null,
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
