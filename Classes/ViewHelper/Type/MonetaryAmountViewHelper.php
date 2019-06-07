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
 * A monetary value or range. This type can be used to describe an amount of money such as $50 USD, or a range as in describing a bank account being suitable for a balance between £1,000 and £1,000,000 GBP, or the value of a salary, etc. It is recommended to use PriceSpecification Types to describe the price of an Offer, Invoice, etc.
 *
 * schema.org version 3.6
 */
class MonetaryAmountViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('currency', 'mixed', 'The currency in which the monetary amount is expressed.');
        $this->registerArgument('maxValue', 'mixed', 'The upper value of some characteristic or property.');
        $this->registerArgument('minValue', 'mixed', 'The lower value of some characteristic or property.');
        $this->registerArgument('validFrom', 'mixed', 'The date when the item becomes valid.');
        $this->registerArgument('validThrough', 'mixed', 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.');
        $this->registerArgument('value', 'mixed', 'The value of the quantitative value or property value node.');
    }
}
