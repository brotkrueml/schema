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
 * Enumerated status values for Order.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum OrderStatus implements EnumerationInterface
{
    /**
     * OrderStatus representing cancellation of an order.
     */
    case OrderCancelled;

    /**
     * OrderStatus representing successful delivery of an order.
     */
    case OrderDelivered;

    /**
     * OrderStatus representing that an order is in transit.
     */
    case OrderInTransit;

    /**
     * OrderStatus representing that payment is due on an order.
     */
    case OrderPaymentDue;

    /**
     * OrderStatus representing availability of an order for pickup.
     */
    case OrderPickupAvailable;

    /**
     * OrderStatus representing that there is a problem with the order.
     */
    case OrderProblem;

    /**
     * OrderStatus representing that an order is being processed.
     */
    case OrderProcessing;

    /**
     * OrderStatus representing that an order has been returned.
     */
    case OrderReturned;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
