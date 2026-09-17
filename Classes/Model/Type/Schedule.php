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
 * A schedule defines a repeating time period used to describe a regularly occurring Event. At a minimum a schedule will specify repeatFrequency which describes the interval between occurrences of the event. Additional information can be provided to specify the schedule more precisely.
 * This includes identifying the day(s) of the week or month when the recurring event will take place, in addition to its start and end time. Schedules may also
 * have start and end dates to indicate when they are active, e.g. to define a limited calendar of events.
 */
#[Type('Schedule')]
final class Schedule extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'byDay',
        'byMonth',
        'byMonthDay',
        'byMonthWeek',
        'description',
        'disambiguatingDescription',
        'duration',
        'endDate',
        'endTime',
        'exceptDate',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'repeatCount',
        'repeatFrequency',
        'sameAs',
        'scheduleTimezone',
        'startDate',
        'startTime',
        'subjectOf',
        'url',
    ];
}
