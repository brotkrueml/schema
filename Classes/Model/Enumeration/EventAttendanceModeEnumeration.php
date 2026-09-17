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
 * An EventAttendanceModeEnumeration value is one of potentially several modes of organising an event, relating to whether it is online or offline.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum EventAttendanceModeEnumeration implements EnumerationInterface
{
    /**
     * MixedEventAttendanceMode - an event that is conducted as a combination of both offline and online modes.
     */
    case MixedEventAttendanceMode;

    /**
     * OfflineEventAttendanceMode - an event that is primarily conducted offline.
     */
    case OfflineEventAttendanceMode;

    /**
     * OnlineEventAttendanceMode - an event that is primarily conducted online.
     */
    case OnlineEventAttendanceMode;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
