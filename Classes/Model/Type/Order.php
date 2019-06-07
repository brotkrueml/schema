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
 * An order is a confirmation of a transaction (a receipt), which can contain multiple line items, each represented by an Offer that has been accepted by the customer.
 *
 * schema.org version 3.6
 */
class Order extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('acceptedOffer', 'billingAddress', 'broker', 'confirmationNumber', 'customer', 'discount', 'discountCode', 'discountCurrency', 'isGift', 'orderDate', 'orderDelivery', 'orderNumber', 'orderStatus', 'orderedItem', 'partOfInvoice', 'paymentDueDate', 'paymentMethod', 'paymentMethodId', 'paymentUrl', 'seller');
    }
}
