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
 * A statistical distribution of monetary amounts.
 *
 * schema.org version 3.6
 */
class MonetaryAmountDistributionViewHelper extends QuantitativeValueDistributionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('currency', 'mixed', 'The currency in which the monetary amount is expressed.');
    }
}
