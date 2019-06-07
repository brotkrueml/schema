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
 * A property-value pair, e.g. representing a feature of a product or place. Use the \'name\' property for the name of the property. If there is an additional human-readable version of the value, put that into the \'description\' property.
 *
 * schema.org version 3.6
 */
class PropertyValueViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('maxValue', 'mixed', 'The upper value of some characteristic or property.');
        $this->registerArgument('minValue', 'mixed', 'The lower value of some characteristic or property.');
        $this->registerArgument('propertyID', 'mixed', 'A commonly used identifier for the characteristic represented by the property, e.g. a manufacturer or a standard code for a property. propertyID can be');
        $this->registerArgument('unitCode', 'mixed', 'The unit of measurement given using the UN/CEFACT Common Code (3 characters) or a URL. Other codes than the UN/CEFACT Common Code may be used with a prefix followed by a colon.');
        $this->registerArgument('unitText', 'mixed', 'A string or text indicating the unit of measurement. Useful if you cannot provide a standard unit code for');
        $this->registerArgument('value', 'mixed', 'The value of the quantitative value or property value node.');
        $this->registerArgument('valueReference', 'mixed', 'A pointer to a secondary value that provides additional information on the original value, e.g. a reference temperature.');
    }
}
