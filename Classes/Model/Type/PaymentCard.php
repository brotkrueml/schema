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
 * A payment method using a credit, debit, store or other card to associate the payment with an account.
 *
 * schema.org version 3.6
 */
class PaymentCard extends PaymentMethod
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('annualPercentageRate', 'feesAndCommissionsSpecification', 'interestRate');
    }
}
