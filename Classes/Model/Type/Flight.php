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
    protected static $propertyNames = [
        'additionalType',
        'aircraft',
        'alternateName',
        'arrivalAirport',
        'arrivalGate',
        'arrivalTerminal',
        'arrivalTime',
        'boardingPolicy',
        'departureAirport',
        'departureGate',
        'departureTerminal',
        'departureTime',
        'description',
        'disambiguatingDescription',
        'estimatedFlightDuration',
        'flightDistance',
        'flightNumber',
        'identifier',
        'image',
        'mainEntityOfPage',
        'mealService',
        'name',
        'offers',
        'potentialAction',
        'provider',
        'sameAs',
        'seller',
        'subjectOf',
        'url',
        'webCheckinTime',
    ];
}
