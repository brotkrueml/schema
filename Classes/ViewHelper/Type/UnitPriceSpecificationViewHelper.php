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
 * The price asked for a given offer by the respective organization or person.
 *
 * schema.org version 3.6
 */
class UnitPriceSpecificationViewHelper extends PriceSpecificationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('billingIncrement', 'mixed', 'This property specifies the minimal quantity and rounding increment that will be the basis for the billing. The unit of measurement is specified by the unitCode property.');
        $this->registerArgument('priceType', 'mixed', 'A short text or acronym indicating multiple price specifications for the same offer, e.g. SRP for the suggested retail price or INVOICE for the invoice price, mostly used in the car industry.');
        $this->registerArgument('referenceQuantity', 'mixed', 'The reference quantity for which a certain price applies, e.g. 1 EUR per 4 kWh of electricity. This property is a replacement for unitOfMeasurement for the advanced cases where the price does not relate to a standard unit.');
        $this->registerArgument('unitCode', 'mixed', 'The unit of measurement given using the UN/CEFACT Common Code (3 characters) or a URL. Other codes than the UN/CEFACT Common Code may be used with a prefix followed by a colon.');
        $this->registerArgument('unitText', 'mixed', 'A string or text indicating the unit of measurement. Useful if you cannot provide a standard unit code for');
    }
}
