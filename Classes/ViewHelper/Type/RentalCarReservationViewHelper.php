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
 * A reservation for a rental car.
 *
 * schema.org version 3.6
 */
class RentalCarReservationViewHelper extends ReservationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('dropoffLocation', 'mixed', 'Where a rental car can be dropped off.');
        $this->registerArgument('dropoffTime', 'mixed', 'When a rental car can be dropped off.');
        $this->registerArgument('pickupLocation', 'mixed', 'Where a taxi will pick up a passenger or a rental car can be picked up.');
        $this->registerArgument('pickupTime', 'mixed', 'When a taxi will pickup a passenger or a rental car can be picked up.');
    }
}
