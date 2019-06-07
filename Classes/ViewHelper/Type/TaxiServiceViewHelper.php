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
 * A service for a vehicle for hire with a driver for local travel. Fares are usually calculated based on distance traveled.
 *
 * schema.org version 3.6
 */
class TaxiServiceViewHelper extends ServiceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
