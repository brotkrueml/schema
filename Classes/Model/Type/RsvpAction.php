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
    protected $properties = [
        'about' => null,
        'actionStatus' => null,
        'additionalNumberOfGuests' => null,
        'additionalType' => null,
        'agent' => null,
        'alternateName' => null,
        'comment' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'endTime' => null,
        'error' => null,
        'event' => null,
        'identifier' => null,
        'image' => null,
        'inLanguage' => null,
        'instrument' => null,
        'location' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'object' => null,
        'participant' => null,
        'potentialAction' => null,
        'recipient' => null,
        'result' => null,
        'rsvpResponse' => null,
        'sameAs' => null,
        'startTime' => null,
        'subjectOf' => null,
        'target' => null,
        'url' => null,
    ];
}
