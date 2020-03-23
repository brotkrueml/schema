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
 * A reservation for lodging at a hotel, motel, inn, etc.
 */
final class LodgingReservation extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'bookingTime',
        'broker',
        'checkinTime',
        'checkoutTime',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'lodgingUnitDescription',
        'lodgingUnitType',
        'mainEntityOfPage',
        'modifiedTime',
        'name',
        'numAdults',
        'numChildren',
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
