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
 * Used to describe a seat, such as a reserved seat in an event reservation.
 *
 * schema.org version 3.6
 */
class SeatViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('seatNumber', 'mixed', 'The location of the reserved seat (e.g., 27).');
        $this->registerArgument('seatRow', 'mixed', 'The row location of the reserved seat (e.g., B).');
        $this->registerArgument('seatSection', 'mixed', 'The section location of the reserved seat (e.g. Orchestra).');
        $this->registerArgument('seatingType', 'mixed', 'The type/class of the seat.');
    }
}
