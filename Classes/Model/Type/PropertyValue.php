<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class PropertyValue extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('maxValue', 'minValue', 'propertyID', 'unitCode', 'unitText', 'value', 'valueReference');
    }
}
