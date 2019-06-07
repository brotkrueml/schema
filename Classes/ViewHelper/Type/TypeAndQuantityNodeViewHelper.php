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
 * A structured value indicating the quantity, unit of measurement, and business function of goods included in a bundle offer.
 *
 * schema.org version 3.6
 */
class TypeAndQuantityNodeViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('amountOfThisGood', 'mixed', 'The quantity of the goods included in the offer.');
        $this->registerArgument('businessFunction', 'mixed', 'The business function (e.g. sell, lease, repair, dispose) of the offer or component of a bundle (TypeAndQuantityNode). The default is http://purl.org/goodrelations/v1#Sell.');
        $this->registerArgument('typeOfGood', 'mixed', 'The product that this structured value is referring to.');
        $this->registerArgument('unitCode', 'mixed', 'The unit of measurement given using the UN/CEFACT Common Code (3 characters) or a URL. Other codes than the UN/CEFACT Common Code may be used with a prefix followed by a colon.');
        $this->registerArgument('unitText', 'mixed', 'A string or text indicating the unit of measurement. Useful if you cannot provide a standard unit code for');
    }
}
