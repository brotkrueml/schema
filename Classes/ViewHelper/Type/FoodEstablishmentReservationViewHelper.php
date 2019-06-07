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
 * A reservation to dine at a food-related business.
 *
 * schema.org version 3.6
 */
class FoodEstablishmentReservationViewHelper extends ReservationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('endTime', 'mixed', 'The endTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to end. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December. For media, including audio and video, it\'s the time offset of the end of a clip within a larger file.');
        $this->registerArgument('partySize', 'mixed', 'Number of people the reservation should accommodate.');
        $this->registerArgument('startTime', 'mixed', 'The startTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to start. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December. For media, including audio and video, it\'s the time offset of the start of a clip within a larger file.');
    }
}
