<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A series of Events. Included events can relate with the series using the superEvent property.
 *
 * An EventSeries is a collection of events that share some unifying characteristic. For example, "The Olympic Games" is a series, which
 * is repeated regularly. The "2012 London Olympics" can be presented both as an Event in the series "Olympic Games", and as an
 * EventSeries that included a number of sporting competitions as Events.
 *
 * The nature of the association between the events in an EventSeries can vary, but typical examples could
 * include a thematic event series (e.g. topical meetups or classes), or a series of regular events that share a location, attendee group and/or organizers.
 *
 * EventSeries has been defined as a kind of Event to make it easy for publishers to use it in an Event context without
 * worrying about which kinds of series are really event-like enough to call an Event. In general an EventSeries
 * may seem more Event-like when the period of time is compact and when aspects such as location are fixed, but
 * it may also sometimes prove useful to describe a longer-term series as an Event.
 */
final class EventSeriesViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'EventSeries';
}
