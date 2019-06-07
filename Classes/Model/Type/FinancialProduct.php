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
 * A product provided to consumers and businesses by financial institutions such as banks, insurance companies, brokerage firms, consumer finance companies, and investment companies which comprise the financial services industry.
 *
 * schema.org version 3.6
 */
class FinancialProduct extends Service
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('annualPercentageRate', 'feesAndCommissionsSpecification', 'interestRate');
    }
}
