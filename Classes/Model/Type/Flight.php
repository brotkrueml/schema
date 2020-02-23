<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * An airline flight.
 */
final class Flight extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'aircraft' => null,
        'alternateName' => null,
        'arrivalAirport' => null,
        'arrivalGate' => null,
        'arrivalTerminal' => null,
        'arrivalTime' => null,
        'boardingPolicy' => null,
        'departureAirport' => null,
        'departureGate' => null,
        'departureTerminal' => null,
        'departureTime' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'estimatedFlightDuration' => null,
        'flightDistance' => null,
        'flightNumber' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'mealService' => null,
        'name' => null,
        'offers' => null,
        'potentialAction' => null,
        'provider' => null,
        'sameAs' => null,
        'seller' => null,
        'subjectOf' => null,
        'url' => null,
        'webCheckinTime' => null,
    ];
}
