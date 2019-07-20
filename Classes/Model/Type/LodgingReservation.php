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
 * A reservation for lodging at a hotel, motel, inn, etc.
 */
final class LodgingReservation extends AbstractType
{
    use TypeTrait\LodgingReservationTrait;
    use TypeTrait\ReservationTrait;
    use TypeTrait\ThingTrait;
}
