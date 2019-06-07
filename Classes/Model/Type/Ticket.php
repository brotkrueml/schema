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
 * Used to describe a ticket to an event, a flight, a bus ride, etc.
 *
 * schema.org version 3.6
 */
class Ticket extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('dateIssued', 'issuedBy', 'priceCurrency', 'ticketNumber', 'ticketToken', 'ticketedSeat', 'totalPrice', 'underName');
    }
}
