<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * Enumerated status values for Reservation.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum ReservationStatusType implements EnumerationInterface
{
    /**
     * The status for a previously confirmed reservation that is now cancelled.
     */
    case ReservationCancelled;

    /**
     * The status of a confirmed reservation.
     */
    case ReservationConfirmed;

    /**
     * The status of a reservation on hold pending an update like credit card number or flight changes.
     */
    case ReservationHold;

    /**
     * The status of a reservation when a request has been sent, but not confirmed.
     */
    case ReservationPending;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
