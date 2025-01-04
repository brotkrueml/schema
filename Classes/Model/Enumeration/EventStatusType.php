<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * EventStatusType is an enumeration type whose instances represent several states that an Event may be in.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum EventStatusType implements EnumerationInterface
{
    /**
     * The event has been cancelled. If the event has multiple startDate values, all are assumed to be cancelled. Either startDate or previousStartDate may be used to specify the event's cancelled date(s).
     */
    case EventCancelled;

    /**
     * Indicates that the event was changed to allow online participation. See eventAttendanceMode for specifics of whether it is now fully or partially online.
     */
    case EventMovedOnline;

    /**
     * The event has been postponed and no new date has been set. The event's previousStartDate should be set.
     */
    case EventPostponed;

    /**
     * The event has been rescheduled. The event's previousStartDate should be set to the old date and the startDate should be set to the event's new date. (If the event has been rescheduled multiple times, the previousStartDate property may be repeated.)
     */
    case EventRescheduled;

    /**
     * The event is taking place or has taken place on the startDate as scheduled. Use of this value is optional, as it is assumed by default.
     */
    case EventScheduled;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
