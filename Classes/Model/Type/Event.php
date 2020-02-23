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
 * An event happening at a certain time and location, such as a concert, lecture, or festival. Ticketing information may be added via the offers property. Repeated events may be structured as separate Event objects.
 */
final class Event extends AbstractType
{
    protected $properties = [
        'about' => null,
        'actor' => null,
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'attendee' => null,
        'audience' => null,
        'composer' => null,
        'contributor' => null,
        'description' => null,
        'director' => null,
        'disambiguatingDescription' => null,
        'doorTime' => null,
        'duration' => null,
        'endDate' => null,
        'eventStatus' => null,
        'funder' => null,
        'identifier' => null,
        'image' => null,
        'inLanguage' => null,
        'isAccessibleForFree' => null,
        'location' => null,
        'mainEntityOfPage' => null,
        'maximumAttendeeCapacity' => null,
        'name' => null,
        'offers' => null,
        'organizer' => null,
        'performer' => null,
        'potentialAction' => null,
        'previousStartDate' => null,
        'recordedIn' => null,
        'remainingAttendeeCapacity' => null,
        'review' => null,
        'sameAs' => null,
        'sponsor' => null,
        'startDate' => null,
        'subEvent' => null,
        'subjectOf' => null,
        'superEvent' => null,
        'translator' => null,
        'typicalAgeRange' => null,
        'url' => null,
        'workFeatured' => null,
        'workPerformed' => null,
    ];
}
