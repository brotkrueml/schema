<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 *
 *
 * The place is __open__ if the opens property is specified, and __closed__ otherwise.
 *
 * If the value for the closes property is less than the value for the opens property then the hour range is assumed to span over the next day.
 */
final class OpeningHoursSpecification extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'closes',
        'dayOfWeek',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'opens',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
    ];
}
