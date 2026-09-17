<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * A type of product fulfillment.
 */
enum FulfillmentTypeEnumeration implements EnumerationInterface
{
    /**
     * Fulfillment to a collection point location.
     */
    case FulfillmentTypeCollectionPoint;

    /**
     * Fulfillment to a customer selected address.
     */
    case FulfillmentTypeDelivery;

    /**
     * Fulfillment through pick-up drop-off locations.
     */
    case FulfillmentTypePickupDropoff;

    /**
     * Fulfillment through pick-up in a store.
     */
    case FulfillmentTypePickupInStore;

    /**
     * Fulfillment to a customer selected address after scheduling with the customer.
     */
    case FulfillmentTypeScheduledDelivery;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
