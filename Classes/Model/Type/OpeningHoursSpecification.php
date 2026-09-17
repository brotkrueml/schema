<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 *
 * The place is __open__ if the opens property is specified, and __closed__ otherwise.
 *
 * If the value for the closes property is less than the value for the opens property then the hour range is assumed to span over the next day.
 */
#[Type('OpeningHoursSpecification')]
#[Manual(Publisher::Google, 'Local Business: Business hours', 'https://developers.google.com/search/docs/appearance/structured-data/local-business#business-hours')]
final class OpeningHoursSpecification extends AbstractType
{
    protected static array $propertyNames = [
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
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
    ];
}
