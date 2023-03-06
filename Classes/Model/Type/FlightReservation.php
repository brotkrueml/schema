<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A reservation for air travel.
 *
 * Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations. For offers of tickets, use Offer.
 */
#[Type('FlightReservation')]
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
