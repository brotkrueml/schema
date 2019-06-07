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
 * A type of Bank Account with a main purpose of depositing funds to gain interest or other benefits.
 *
 * schema.org version 3.6
 */
class DepositAccountViewHelper extends InvestmentOrDepositViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
