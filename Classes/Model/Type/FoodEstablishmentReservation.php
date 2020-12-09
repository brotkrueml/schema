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
 * A reservation to dine at a food-related business.
 *
 * Note: This type is for information about actual reservations, e.g. in confirmation emails or HTML pages with individual confirmations of reservations.
 */
final class FoodEstablishmentReservation extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'bookingTime',
        'broker',
        'description',
        'disambiguatingDescription',
        'endTime',
        'identifier',
        'image',
        'mainEntityOfPage',
        'modifiedTime',
        'name',
        'partySize',
        'potentialAction',
        'priceCurrency',
        'programMembershipUsed',
        'provider',
        'reservationFor',
        'reservationId',
        'reservationStatus',
        'reservedTicket',
        'sameAs',
        'startTime',
        'subjectOf',
        'totalPrice',
        'underName',
        'url',
    ];
}
