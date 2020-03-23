<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * The act of notifying an event organizer as to whether you expect to attend the event.
 */
final class RsvpAction extends AbstractType
{
    protected static $propertyNames = [
        'about',
        'actionStatus',
        'additionalNumberOfGuests',
        'additionalType',
        'agent',
        'alternateName',
        'comment',
        'description',
        'disambiguatingDescription',
        'endTime',
        'error',
        'event',
        'identifier',
        'image',
        'inLanguage',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
        'participant',
        'potentialAction',
        'recipient',
        'result',
        'rsvpResponse',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
