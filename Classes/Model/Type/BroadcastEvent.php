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
 * An over the air or online broadcast event.
 */
#[Type('BroadcastEvent')]
final class BroadcastEvent extends AbstractType
{
    protected static array $propertyNames = [
        'about',
        'actor',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'attendee',
        'audience',
        'broadcastOfEvent',
        'composer',
        'contributor',
        'description',
        'director',
        'disambiguatingDescription',
        'doorTime',
        'duration',
        'endDate',
        'eventStatus',
        'funder',
        'identifier',
        'image',
        'inLanguage',
        'isAccessibleForFree',
        'isLiveBroadcast',
        'keywords',
        'location',
        'mainEntityOfPage',
        'maximumAttendeeCapacity',
        'name',
        'offers',
        'organizer',
        'performer',
        'potentialAction',
        'previousStartDate',
        'publishedOn',
        'recordedIn',
        'remainingAttendeeCapacity',
        'review',
        'sameAs',
        'sponsor',
        'startDate',
        'subEvent',
        'subjectOf',
        'superEvent',
        'translator',
        'typicalAgeRange',
        'url',
        'videoFormat',
        'workFeatured',
        'workPerformed',
    ];
}
