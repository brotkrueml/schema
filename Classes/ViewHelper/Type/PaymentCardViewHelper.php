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
 * A payment method using a credit, debit, store or other card to associate the payment with an account.
 *
 * schema.org version 3.6
 */
class PaymentCardViewHelper extends PaymentMethodViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('annualPercentageRate', 'mixed', 'The annual rate that is charged for borrowing (or made by investing), expressed as a single percentage number that represents the actual yearly cost of funds over the term of a loan. This includes any fees or additional costs associated with the transaction.');
        $this->registerArgument('feesAndCommissionsSpecification', 'mixed', 'Description of fees, commissions, and other terms applied either to a class of financial product, or by a financial service organization.');
        $this->registerArgument('interestRate', 'mixed', 'The interest rate, charged or paid, applicable to the financial product. Note: This is different from the calculated annualPercentageRate.');
    }
}
