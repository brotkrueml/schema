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
 * A structured value representing the duration and scope of services that will be provided to a customer free of charge in case of a defect or malfunction of a product.
 *
 * schema.org version 3.6
 */
class WarrantyPromiseViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('durationOfWarranty', 'mixed', 'The duration of the warranty promise. Common unitCode values are ANN for year, MON for months, or DAY for days.');
        $this->registerArgument('warrantyScope', 'mixed', 'The scope of the warranty promise.');
    }
}
