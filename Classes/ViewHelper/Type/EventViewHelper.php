<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

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
class EventViewHelper extends ThingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('about', 'mixed', 'The subject matter of the content.');
        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('aggregateRating', 'mixed', 'The overall rating, based on a collection of reviews or ratings, of the item.');
        $this->registerArgument('attendee', 'mixed', 'A person or organization attending the event.');
        $this->registerArgument('audience', 'mixed', 'An intended audience, i.e. a group for whom something was created.');
        $this->registerArgument('composer', 'mixed', 'The person or organization who wrote a composition, or who is the composer of a work performed at some event.');
        $this->registerArgument('contributor', 'mixed', 'A secondary contributor to the CreativeWork or Event.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('doorTime', 'mixed', 'The time admission will commence.');
        $this->registerArgument('duration', 'mixed', 'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.');
        $this->registerArgument('endDate', 'mixed', 'The end date and time of the item (in ISO 8601 date format).');
        $this->registerArgument('eventStatus', 'mixed', 'An eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled.');
        $this->registerArgument('funder', 'mixed', 'A person or organization that supports (sponsors) something through some kind of financial contribution.');
        $this->registerArgument('inLanguage', 'mixed', 'The language of the content or performance or used in an action. Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage.');
        $this->registerArgument('isAccessibleForFree', 'mixed', 'A flag to signal that the item, event, or place is accessible for free.');
        $this->registerArgument('location', 'mixed', 'The location of for example where the event is happening, an organization is located, or where an action takes place.');
        $this->registerArgument('maximumAttendeeCapacity', 'mixed', 'The total number of individuals that may attend an event or venue.');
        $this->registerArgument('offers', 'mixed', 'An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.');
        $this->registerArgument('organizer', 'mixed', 'An organizer of an Event.');
        $this->registerArgument('performer', 'mixed', 'A performer at the event&#x2014;for example, a presenter, musician, musical group or actor.');
        $this->registerArgument('previousStartDate', 'mixed', 'Used in conjunction with eventStatus for rescheduled or cancelled events. This property contains the previously scheduled start date. For rescheduled events, the startDate property should be used for the newly scheduled start date. In the (rare) case of an event that has been postponed and rescheduled multiple times, this field may be repeated.');
        $this->registerArgument('recordedIn', 'mixed', 'The CreativeWork that captured all or part of this Event.');
        $this->registerArgument('remainingAttendeeCapacity', 'mixed', 'The number of attendee places for an event that remain unallocated.');
        $this->registerArgument('review', 'mixed', 'A review of the item.');
        $this->registerArgument('sponsor', 'mixed', 'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.');
        $this->registerArgument('startDate', 'mixed', 'The start date and time of the item (in ISO 8601 date format).');
        $this->registerArgument('subEvent', 'mixed', 'An Event that is part of this event. For example, a conference event includes many presentations, each of which is a subEvent of the conference.');
        $this->registerArgument('superEvent', 'mixed', 'An event that this event is a part of. For example, a collection of individual music performances might each have a music festival as their superEvent.');
        $this->registerArgument('translator', 'mixed', 'Organization or person who adapts a creative work to different languages, regional differences and technical requirements of a target market, or that translates during some event.');
        $this->registerArgument('typicalAgeRange', 'mixed', 'The typical expected age range, e.g. \'7-9\', \'11-\'.');
        $this->registerArgument('workFeatured', 'mixed', 'A work featured in some event, e.g. exhibited in an ExhibitionEvent.');
        $this->registerArgument('workPerformed', 'mixed', 'A work performed in some event, for example a play performed in a TheaterEvent.');
    }
}
