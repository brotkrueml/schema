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
 * An order item is a line of an order. It includes the quantity and shipping details of a bought offer.
 *
 * schema.org version 3.6
 */
class OrderItemViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('orderDelivery', 'mixed', 'The delivery of the parcel related to this order or order item.');
        $this->registerArgument('orderItemNumber', 'mixed', 'The identifier of the order item.');
        $this->registerArgument('orderItemStatus', 'mixed', 'The current status of the order item.');
        $this->registerArgument('orderQuantity', 'mixed', 'The number of the item ordered. If the property is not set, assume the quantity is one.');
        $this->registerArgument('orderedItem', 'mixed', 'The item ordered.');
    }
}
