<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * Used to describe a ticket to an event, a flight, a bus ride, etc.
 */
final class Ticket extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'dateIssued',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'issuedBy',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'priceCurrency',
        'sameAs',
        'subjectOf',
        'ticketNumber',
        'ticketToken',
        'ticketedSeat',
        'totalPrice',
        'underName',
        'url',
    ];
}
