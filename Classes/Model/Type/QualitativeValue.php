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
 * A predefined value for a product characteristic, e.g. the power cord plug type \'US\' or the garment sizes \'S\', \'M\', \'L\', and \'XL\'.
 *
 * schema.org version 3.6
 */
class QualitativeValue extends Enumeration
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('additionalProperty', 'equal', 'greater', 'greaterOrEqual', 'lesser', 'lesserOrEqual', 'nonEqual', 'valueReference');
    }
}
