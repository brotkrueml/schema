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
 * A point value or interval for product characteristics and other purposes.
 *
 * schema.org version 3.6
 */
class QuantitativeValueViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalProperty', 'mixed', 'A property-value pair representing an additional characteristics of the entitity, e.g. a product feature or another characteristic for which there is no matching property in schema.org.');
        $this->registerArgument('maxValue', 'mixed', 'The upper value of some characteristic or property.');
        $this->registerArgument('minValue', 'mixed', 'The lower value of some characteristic or property.');
        $this->registerArgument('unitCode', 'mixed', 'The unit of measurement given using the UN/CEFACT Common Code (3 characters) or a URL. Other codes than the UN/CEFACT Common Code may be used with a prefix followed by a colon.');
        $this->registerArgument('unitText', 'mixed', 'A string or text indicating the unit of measurement. Useful if you cannot provide a standard unit code for');
        $this->registerArgument('value', 'mixed', 'The value of the quantitative value or property value node.');
        $this->registerArgument('valueReference', 'mixed', 'A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.');
    }
}
