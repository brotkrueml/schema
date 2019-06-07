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
 * A trip on a commercial bus line.
 *
 * schema.org version 3.6
 */
class BusTripViewHelper extends TripViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('arrivalBusStop', 'mixed', 'The stop or station from which the bus arrives.');
        $this->registerArgument('busName', 'mixed', 'The name of the bus (e.g. Bolt Express).');
        $this->registerArgument('busNumber', 'mixed', 'The unique identifier for the bus.');
        $this->registerArgument('departureBusStop', 'mixed', 'The stop or station from which the bus departs.');
    }
}
