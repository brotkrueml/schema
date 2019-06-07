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
 * An event happening at a certain time and location, such as a concert, lecture, or festival. Ticketing information may be added via the offers property. Repeated events may be structured as separate Event objects.
 *
 * schema.org version 3.6
 */
class Event extends Thing
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('about', 'actor', 'aggregateRating', 'attendee', 'audience', 'composer', 'contributor', 'director', 'doorTime', 'duration', 'endDate', 'eventStatus', 'funder', 'inLanguage', 'isAccessibleForFree', 'location', 'maximumAttendeeCapacity', 'offers', 'organizer', 'performer', 'previousStartDate', 'recordedIn', 'remainingAttendeeCapacity', 'review', 'sponsor', 'startDate', 'subEvent', 'superEvent', 'translator', 'typicalAgeRange', 'workFeatured', 'workPerformed');
    }
}
