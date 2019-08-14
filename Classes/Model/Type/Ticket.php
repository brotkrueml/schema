<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * Used to describe a ticket to an event, a flight, a bus ride, etc.
 */
final class Ticket extends AbstractType
{
    use TypeTrait\ThingTrait;
    use TypeTrait\TicketTrait;
}
