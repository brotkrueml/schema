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
 * A card payment method of a particular brand or name.  Used to mark up a particular payment method and/or the financial product/service that supplies the card account.
 *
 * schema.org version 3.6
 */
class CreditCard extends LoanOrCredit
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('annualPercentageRate', 'feesAndCommissionsSpecification', 'interestRate');
    }
}
