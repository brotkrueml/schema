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
 * A reservation for lodging at a hotel, motel, inn, etc.
 *
 * schema.org version 3.6
 */
class LodgingReservation extends Reservation
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('checkinTime', 'checkoutTime', 'lodgingUnitDescription', 'lodgingUnitType', 'numAdults', 'numChildren');
    }
}
