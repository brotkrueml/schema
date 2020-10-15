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
 * A reservation for a rental car.
 */
final class RentalCarReservation extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'bookingTime',
        'broker',
        'description',
        'disambiguatingDescription',
        'dropoffLocation',
        'dropoffTime',
        'identifier',
        'image',
        'mainEntityOfPage',
        'modifiedTime',
        'name',
        'pickupLocation',
        'pickupTime',
        'potentialAction',
        'priceCurrency',
        'programMembershipUsed',
        'provider',
        'reservationFor',
        'reservationId',
        'reservationStatus',
        'reservedTicket',
        'sameAs',
        'subjectOf',
        'totalPrice',
        'underName',
        'url',
    ];
}
