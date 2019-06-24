<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
trait FlightTrait
{
    protected $aircraft;
    protected $arrivalAirport;
    protected $arrivalGate;
    protected $arrivalTerminal;
    protected $boardingPolicy;
    protected $departureAirport;
    protected $departureGate;
    protected $departureTerminal;
    protected $estimatedFlightDuration;
    protected $flightDistance;
    protected $flightNumber;
    protected $mealService;
    protected $seller;
    protected $webCheckinTime;
}
