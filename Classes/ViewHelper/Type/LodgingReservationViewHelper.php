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
 * A reservation for lodging at a hotel, motel, inn, etc.
 *
 * schema.org version 3.6
 */
class LodgingReservationViewHelper extends ReservationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('checkinTime', 'mixed', 'The earliest someone may check into a lodging establishment.');
        $this->registerArgument('checkoutTime', 'mixed', 'The latest someone may check out of a lodging establishment.');
        $this->registerArgument('lodgingUnitDescription', 'mixed', 'A full description of the lodging unit.');
        $this->registerArgument('lodgingUnitType', 'mixed', 'Textual description of the unit type (including suite vs. room, size of bed, etc.).');
        $this->registerArgument('numAdults', 'mixed', 'The number of adults staying in the unit.');
        $this->registerArgument('numChildren', 'mixed', 'The number of children staying in the unit.');
    }
}
