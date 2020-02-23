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
 * A reservation for train travel.
 */
final class TrainReservation extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'bookingTime' => null,
        'broker' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'modifiedTime' => null,
        'name' => null,
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
