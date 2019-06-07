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
 * Residence type: Single-family home.
 *
 * schema.org version 3.6
 */
class SingleFamilyResidenceViewHelper extends HouseViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('numberOfRooms', 'mixed', 'The number of rooms (excluding bathrooms and closets) of the accommodation or lodging business.');
        $this->registerArgument('occupancy', 'mixed', 'The allowed total occupancy for the accommodation in persons (including infants etc). For individual accommodations, this is not necessarily the legal maximum but defines the permitted usage as per the contractual agreement (e.g. a double room used by a single person).');
    }
}
