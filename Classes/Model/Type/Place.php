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
 * Entities that have a somewhat fixed, physical extension.
 */
#[Type('Place')]
#[Manual(Publisher::Yandex, 'Addresses and organizations', 'https://yandex.com/support/webmaster/supported-schemas/address-organization.html')]
final class Place extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
        'additionalType',
        'address',
        'aggregateRating',
        'alternateName',
        'amenityFeature',
        'branchCode',
        'containedInPlace',
        'containsPlace',
        'description',
        'disambiguatingDescription',
        'event',
        'faxNumber',
        'geo',
        'geoContains',
        'geoCoveredBy',
        'geoCovers',
        'geoCrosses',
        'geoDisjoint',
        'geoEquals',
        'geoIntersects',
        'geoOverlaps',
        'geoTouches',
        'geoWithin',
        'globalLocationNumber',
        'hasCertification',
        'hasMap',
        'identifier',
        'image',
        'isAccessibleForFree',
        'isicV4',
        'keywords',
        'latitude',
        'logo',
        'longitude',
        'mainEntityOfPage',
        'maximumAttendeeCapacity',
        'name',
        'openingHoursSpecification',
        'photo',
        'potentialAction',
        'publicAccess',
        'review',
        'sameAs',
        'slogan',
        'smokingAllowed',
        'specialOpeningHoursSpecification',
        'subjectOf',
        'telephone',
        'url',
    ];
}
