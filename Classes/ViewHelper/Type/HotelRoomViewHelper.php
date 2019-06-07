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
 * A hotel room is a single room in a hotel.
 *
 * schema.org version 3.6
 */
class HotelRoomViewHelper extends RoomViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('bed', 'mixed', 'The type of bed or beds included in the accommodation. For the single case of just one bed of a certain type, you use bed directly with a text.');
        $this->registerArgument('occupancy', 'mixed', 'The allowed total occupancy for the accommodation in persons (including infants etc). For individual accommodations, this is not necessarily the legal maximum but defines the permitted usage as per the contractual agreement (e.g. a double room used by a single person).');
    }
}
