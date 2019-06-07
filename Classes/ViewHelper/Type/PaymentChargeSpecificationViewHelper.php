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
 * The costs of settling the payment using a particular payment method.
 *
 * schema.org version 3.6
 */
class PaymentChargeSpecificationViewHelper extends PriceSpecificationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('appliesToDeliveryMethod', 'mixed', 'The delivery method(s) to which the delivery charge or payment charge specification applies.');
        $this->registerArgument('appliesToPaymentMethod', 'mixed', 'The payment method(s) to which the payment charge specification applies.');
    }
}
