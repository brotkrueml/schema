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
 * A reservation for a taxi.
 *
 * schema.org version 3.6
 */
class TaxiReservationViewHelper extends ReservationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('partySize', 'mixed', 'Number of people the reservation should accommodate.');
        $this->registerArgument('pickupLocation', 'mixed', 'Where a taxi will pick up a passenger or a rental car can be picked up.');
        $this->registerArgument('pickupTime', 'mixed', 'When a taxi will pickup a passenger or a rental car can be picked up.');
    }
}
