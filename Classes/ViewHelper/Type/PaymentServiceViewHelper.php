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
 * A Service to transfer funds from a person or organization to a beneficiary person or organization.
 *
 * schema.org version 3.6
 */
class PaymentServiceViewHelper extends FinancialProductViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
