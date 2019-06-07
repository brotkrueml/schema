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
 * A financial product for the loaning of an amount of money under agreed terms and charges.
 *
 * schema.org version 3.6
 */
class LoanOrCreditViewHelper extends FinancialProductViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('amount', 'mixed', 'The amount of money.');
        $this->registerArgument('currency', 'mixed', 'The currency in which the monetary amount is expressed.');
        $this->registerArgument('loanTerm', 'mixed', 'The duration of the loan or credit agreement.');
        $this->registerArgument('requiredCollateral', 'mixed', 'Assets required to secure loan or credit repayments. It may take form of third party pledge, goods, financial instruments (cash, securities, etc.)');
    }
}
