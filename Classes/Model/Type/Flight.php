<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

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
        'sameAs',
        'seller',
        'subjectOf',
        'tripOrigin',
        'url',
        'webCheckinTime',
    ];
}
