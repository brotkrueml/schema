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
 * An order item is a line of an order. It includes the quantity and shipping details of a bought offer.
 *
 * schema.org version 3.6
 */
class OrderItem extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('orderDelivery', 'orderItemNumber', 'orderItemStatus', 'orderQuantity', 'orderedItem');
    }
}
