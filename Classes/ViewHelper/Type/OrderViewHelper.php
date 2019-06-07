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
 * An order is a confirmation of a transaction (a receipt), which can contain multiple line items, each represented by an Offer that has been accepted by the customer.
 *
 * schema.org version 3.6
 */
class OrderViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('acceptedOffer', 'mixed', 'The offer(s) -- e.g., product, quantity and price combinations -- included in the order.');
        $this->registerArgument('billingAddress', 'mixed', 'The billing address for the order.');
        $this->registerArgument('broker', 'mixed', 'An entity that arranges for an exchange between a buyer and a seller.  In most cases a broker never acquires or releases ownership of a product or service involved in an exchange.  If it is not clear whether an entity is a broker, seller, or buyer, the latter two terms are preferred.');
        $this->registerArgument('confirmationNumber', 'mixed', 'A number that confirms the given order or payment has been received.');
        $this->registerArgument('customer', 'mixed', 'Party placing the order or paying the invoice.');
        $this->registerArgument('discount', 'mixed', 'Any discount applied (to an Order).');
        $this->registerArgument('discountCode', 'mixed', 'Code used to redeem a discount.');
        $this->registerArgument('discountCurrency', 'mixed', 'The currency of the discount.');
        $this->registerArgument('isGift', 'mixed', 'Was the offer accepted as a gift for someone other than the buyer.');
        $this->registerArgument('orderDate', 'mixed', 'Date order was placed.');
        $this->registerArgument('orderDelivery', 'mixed', 'The delivery of the parcel related to this order or order item.');
        $this->registerArgument('orderNumber', 'mixed', 'The identifier of the transaction.');
        $this->registerArgument('orderStatus', 'mixed', 'The current status of the order.');
        $this->registerArgument('orderedItem', 'mixed', 'The item ordered.');
        $this->registerArgument('partOfInvoice', 'mixed', 'The order is being paid as part of the referenced Invoice.');
        $this->registerArgument('paymentDueDate', 'mixed', 'The date that payment is due.');
        $this->registerArgument('paymentMethod', 'mixed', 'The name of the credit card or other method of payment for the order.');
        $this->registerArgument('paymentMethodId', 'mixed', 'An identifier for the method of payment used (e.g. the last 4 digits of the credit card).');
        $this->registerArgument('paymentUrl', 'mixed', 'The URL for sending a payment.');
        $this->registerArgument('seller', 'mixed', 'An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.');
    }
}
