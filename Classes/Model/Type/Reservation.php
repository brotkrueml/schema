<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * Describes a reservation for travel, dining or an event. Some reservations require tickets.
 */
class Reservation extends AbstractType
{
    use TypeTrait\ReservationTrait;
    use TypeTrait\ThingTrait;
}
