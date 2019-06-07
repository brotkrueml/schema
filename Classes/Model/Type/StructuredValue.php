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
 * Structured values are used when the value of a property has a more complex structure than simply being a textual value or a reference to another thing.
 *
 * schema.org version 3.6
 */
class StructuredValue extends Intangible
{
    public function __construct()
    {
        parent::__construct();
    }
}
