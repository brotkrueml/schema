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
 * An airline flight.
 *
 * schema.org version 3.6
 */
class FlightViewHelper extends TripViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('aircraft', 'mixed', 'The kind of aircraft (e.g., "Boeing 747").');
        $this->registerArgument('arrivalAirport', 'mixed', 'The airport where the flight terminates.');
        $this->registerArgument('arrivalGate', 'mixed', 'Identifier of the flight\'s arrival gate.');
        $this->registerArgument('arrivalTerminal', 'mixed', 'Identifier of the flight\'s arrival terminal.');
        $this->registerArgument('boardingPolicy', 'mixed', 'The type of boarding policy used by the airline (e.g. zone-based or group-based).');
        $this->registerArgument('departureAirport', 'mixed', 'The airport where the flight originates.');
        $this->registerArgument('departureGate', 'mixed', 'Identifier of the flight\'s departure gate.');
        $this->registerArgument('departureTerminal', 'mixed', 'Identifier of the flight\'s departure terminal.');
        $this->registerArgument('estimatedFlightDuration', 'mixed', 'The estimated time the flight will take.');
        $this->registerArgument('flightDistance', 'mixed', 'The distance of the flight.');
        $this->registerArgument('flightNumber', 'mixed', 'The unique identifier for a flight including the airline IATA code. For example, if describing United flight 110, where the IATA code for United is \'UA\', the flightNumber is \'UA110\'.');
        $this->registerArgument('mealService', 'mixed', 'Description of the meals that will be provided or available for purchase.');
        $this->registerArgument('seller', 'mixed', 'An entity which offers (sells / leases / lends / loans) the services / goods.  A seller may also be a provider.');
        $this->registerArgument('webCheckinTime', 'mixed', 'The time when a passenger can check into the flight online.');
    }
}
