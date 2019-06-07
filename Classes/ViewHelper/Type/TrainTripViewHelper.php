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
 * A trip on a commercial train line.
 *
 * schema.org version 3.6
 */
class TrainTripViewHelper extends TripViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('arrivalPlatform', 'mixed', 'The platform where the train arrives.');
        $this->registerArgument('arrivalStation', 'mixed', 'The station where the train trip ends.');
        $this->registerArgument('departurePlatform', 'mixed', 'The platform from which the train departs.');
        $this->registerArgument('departureStation', 'mixed', 'The station from which the train departs.');
        $this->registerArgument('trainName', 'mixed', 'The name of the train (e.g. The Orient Express).');
        $this->registerArgument('trainNumber', 'mixed', 'The unique identifier for the train.');
    }
}
