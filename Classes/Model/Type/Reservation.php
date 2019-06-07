<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Describes a reservation for travel, dining or an event. Some reservations require tickets.
 *
 * schema.org version 3.6
 */
class Reservation extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('bookingTime', 'broker', 'modifiedTime', 'priceCurrency', 'programMembershipUsed', 'provider', 'reservationFor', 'reservationId', 'reservationStatus', 'reservedTicket', 'totalPrice', 'underName');
    }
}
