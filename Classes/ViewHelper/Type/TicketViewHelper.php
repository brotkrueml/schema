<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

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
class TicketViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('dateIssued', 'mixed', 'The date the ticket was issued.');
        $this->registerArgument('issuedBy', 'mixed', 'The organization issuing the ticket or permit.');
        $this->registerArgument('priceCurrency', 'mixed', 'The currency of the price, or a price component when attached to PriceSpecification and its subtypes.');
        $this->registerArgument('ticketNumber', 'mixed', 'The unique identifier for the ticket.');
        $this->registerArgument('ticketToken', 'mixed', 'Reference to an asset (e.g., Barcode, QR code image or PDF) usable for entrance.');
        $this->registerArgument('ticketedSeat', 'mixed', 'The seat associated with the ticket.');
        $this->registerArgument('totalPrice', 'mixed', 'The total price for the reservation or ticket, including applicable taxes, shipping, etc.');
        $this->registerArgument('underName', 'mixed', 'The person or organization the reservation or ticket is for.');
    }
}
