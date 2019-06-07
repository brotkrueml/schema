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
 * A Property value specification.
 *
 * schema.org version 3.6
 */
class PropertyValueSpecification extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('defaultValue', 'maxValue', 'minValue', 'multipleValues', 'readonlyValue', 'stepValue', 'valueMaxLength', 'valueMinLength', 'valueName', 'valuePattern', 'valueRequired');
    }
}
