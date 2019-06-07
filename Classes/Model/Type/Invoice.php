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
 * A statement of the money due for goods or services; a bill.
 *
 * schema.org version 3.6
 */
class Invoice extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('accountId', 'billingPeriod', 'broker', 'category', 'confirmationNumber', 'customer', 'minimumPaymentDue', 'paymentDueDate', 'paymentMethod', 'paymentMethodId', 'paymentStatus', 'provider', 'referencesOrder', 'scheduledPaymentDate', 'totalPaymentDue');
    }
}
