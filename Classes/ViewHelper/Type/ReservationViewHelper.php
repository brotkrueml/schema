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
 * Describes a reservation for travel, dining or an event. Some reservations require tickets.
 *
 * schema.org version 3.6
 */
class ReservationViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('bookingTime', 'mixed', 'The date and time the reservation was booked.');
        $this->registerArgument('broker', 'mixed', 'An entity that arranges for an exchange between a buyer and a seller.  In most cases a broker never acquires or releases ownership of a product or service involved in an exchange.  If it is not clear whether an entity is a broker, seller, or buyer, the latter two terms are preferred.');
        $this->registerArgument('modifiedTime', 'mixed', 'The date and time the reservation was modified.');
        $this->registerArgument('priceCurrency', 'mixed', 'The currency of the price, or a price component when attached to PriceSpecification and its subtypes.');
        $this->registerArgument('programMembershipUsed', 'mixed', 'Any membership in a frequent flyer, hotel loyalty program, etc. being applied to the reservation.');
        $this->registerArgument('provider', 'mixed', 'The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.');
        $this->registerArgument('reservationFor', 'mixed', 'The thing -- flight, event, restaurant,etc. being reserved.');
        $this->registerArgument('reservationId', 'mixed', 'A unique identifier for the reservation.');
        $this->registerArgument('reservationStatus', 'mixed', 'The current status of the reservation.');
        $this->registerArgument('reservedTicket', 'mixed', 'A ticket associated with the reservation.');
        $this->registerArgument('totalPrice', 'mixed', 'The total price for the reservation or ticket, including applicable taxes, shipping, etc.');
        $this->registerArgument('underName', 'mixed', 'The person or organization the reservation or ticket is for.');
    }
}
