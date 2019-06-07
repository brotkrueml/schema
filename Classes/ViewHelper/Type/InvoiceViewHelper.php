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
 * A statement of the money due for goods or services; a bill.
 *
 * schema.org version 3.6
 */
class InvoiceViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('accountId', 'mixed', 'The identifier for the account the payment will be applied to.');
        $this->registerArgument('billingPeriod', 'mixed', 'The time interval used to compute the invoice.');
        $this->registerArgument('broker', 'mixed', 'An entity that arranges for an exchange between a buyer and a seller.  In most cases a broker never acquires or releases ownership of a product or service involved in an exchange.  If it is not clear whether an entity is a broker, seller, or buyer, the latter two terms are preferred.');
        $this->registerArgument('category', 'mixed', 'A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.');
        $this->registerArgument('confirmationNumber', 'mixed', 'A number that confirms the given order or payment has been received.');
        $this->registerArgument('customer', 'mixed', 'Party placing the order or paying the invoice.');
        $this->registerArgument('minimumPaymentDue', 'mixed', 'The minimum payment required at this time.');
        $this->registerArgument('paymentDueDate', 'mixed', 'The date that payment is due.');
        $this->registerArgument('paymentMethod', 'mixed', 'The name of the credit card or other method of payment for the order.');
        $this->registerArgument('paymentMethodId', 'mixed', 'An identifier for the method of payment used (e.g. the last 4 digits of the credit card).');
        $this->registerArgument('paymentStatus', 'mixed', 'The status of payment; whether the invoice has been paid or not.');
        $this->registerArgument('provider', 'mixed', 'The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.');
        $this->registerArgument('referencesOrder', 'mixed', 'The Order(s) related to this Invoice. One or more Orders may be combined into a single Invoice.');
        $this->registerArgument('scheduledPaymentDate', 'mixed', 'The date the invoice is scheduled to be paid.');
        $this->registerArgument('totalPaymentDue', 'mixed', 'The total amount due.');
    }
}
