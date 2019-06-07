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
 * A point value or interval for product characteristics and other purposes.
 *
 * schema.org version 3.6
 */
class QuantitativeValue extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('additionalProperty', 'maxValue', 'minValue', 'unitCode', 'unitText', 'value', 'valueReference');
    }
}
