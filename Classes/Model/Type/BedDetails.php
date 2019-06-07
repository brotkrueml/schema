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
 * An entity holding detailed information about the available bed types, e.g. the quantity of twin beds for a hotel room. For the single case of just one bed of a certain type, you can use bed directly with a text. See also BedType (under development).
 *
 * schema.org version 3.6
 */
class BedDetails extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('numberOfBeds', 'typeOfBed');
    }
}
