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
 * A type of financial product that typically requires the client to transfer funds to a financial service in return for potential beneficial financial return.
 *
 * schema.org version 3.6
 */
class InvestmentOrDeposit extends FinancialProduct
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('amount');
    }
}
