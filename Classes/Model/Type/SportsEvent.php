<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * Event type: Sports event.
 */
#[Type('SportsEvent')]
final class SportsEvent extends AbstractType
{
    protected static array $propertyNames = [
        'about',
        'actor',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'attendee',
        'audience',
        'awayTeam',
        'competitor',
        'composer',
        'contributor',
        'description',
        'director',
        'disambiguatingDescription',
        'doorTime',
        'duration',
        'endDate',
        'eventAttendanceMode',
        'eventSchedule',
        'eventStatus',
        'funder',
        'funding',
        'homeTeam',
        'identifier',
        'image',
        'inLanguage',
        'isAccessibleForFree',
        'keywords',
        'location',
        'mainEntityOfPage',
        'maximumAttendeeCapacity',
        'maximumPhysicalAttendeeCapacity',
        'maximumVirtualAttendeeCapacity',
        'name',
        'offers',
        'organizer',
        'owner',
        'performer',
        'potentialAction',
        'previousStartDate',
        'recordedIn',
        'referee',
        'remainingAttendeeCapacity',
        'review',
        'sameAs',
        'sponsor',
        'sport',
        'startDate',
        'subEvent',
        'subjectOf',
        'superEvent',
        'translator',
        'typicalAgeRange',
        'url',
        'workFeatured',
        'workPerformed',
    ];
}
