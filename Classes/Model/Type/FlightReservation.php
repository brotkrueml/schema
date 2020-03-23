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
 * A reservation for air travel.
 */
final class FlightReservation extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'boardingGroup',
        'bookingTime',
        'broker',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'modifiedTime',
        'name',
        'passengerPriorityStatus',
        'passengerSequenceNumber',
        'potentialAction',
        'priceCurrency',
        'programMembershipUsed',
        'provider',
        'reservationFor',
        'reservationId',
        'reservationStatus',
        'reservedTicket',
        'sameAs',
        'securityScreening',
        'subjectOf',
        'totalPrice',
        'underName',
        'url',
    ];
}
