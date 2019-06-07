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
 * Financial services business.
 *
 * schema.org version 3.6
 */
class FinancialServiceViewHelper extends LocalBusinessViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('feesAndCommissionsSpecification', 'mixed', 'Description of fees, commissions, and other terms applied either to a class of financial product, or by a financial service organization.');
    }
}
