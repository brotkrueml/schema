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
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'bookingTime' => null,
        'broker' => null,
        'checkinTime' => null,
        'checkoutTime' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'lodgingUnitDescription' => null,
        'lodgingUnitType' => null,
        'mainEntityOfPage' => null,
        'modifiedTime' => null,
        'name' => null,
        'numAdults' => null,
        'numChildren' => null,
        'potentialAction' => null,
        'priceCurrency' => null,
        'programMembershipUsed' => null,
        'provider' => null,
        'reservationFor' => null,
        'reservationId' => null,
        'reservationStatus' => null,
        'reservedTicket' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'totalPrice' => null,
        'underName' => null,
        'url' => null,
    ];
}
