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
 * A reservation for air travel.
 *
 * schema.org version 3.6
 */
class FlightReservationViewHelper extends ReservationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('boardingGroup', 'mixed', 'The airline-specific indicator of boarding order / preference.');
        $this->registerArgument('passengerPriorityStatus', 'mixed', 'The priority status assigned to a passenger for security or boarding (e.g. FastTrack or Priority).');
        $this->registerArgument('passengerSequenceNumber', 'mixed', 'The passenger\'s sequence number as assigned by the airline.');
        $this->registerArgument('securityScreening', 'mixed', 'The type of security screening the passenger is subject to.');
    }
}
