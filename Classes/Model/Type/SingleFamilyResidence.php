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
 * Residence type: Single-family home.
 *
 * schema.org version 3.6
 */
class SingleFamilyResidence extends House
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('numberOfRooms', 'occupancy');
    }
}
