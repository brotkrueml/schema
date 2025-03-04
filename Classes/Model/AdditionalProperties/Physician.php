<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\AdditionalProperties;

use Brotkrueml\Schema\Core\AdditionalPropertiesInterface;

/**
 * Physician has been cleaned up. Some properties have been removed from the type.
 * @see https://github.com/schemaorg/schemaorg/pull/3427
 *
 * @internal
 * @todo Remove with schema 4.0.0
 */
final class Physician implements AdditionalPropertiesInterface
{
    public function getType(): string
    {
        return 'Physician';
    }

    public function getAdditionalProperties(): array
    {
        return [
            'additionalProperty',
            'amenityFeature',
            'branchCode',
            'containedInPlace',
            'containsPlace',
            'currenciesAccepted',
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
            'hasMap',
            'isAccessibleForFree',
            'latitude',
            'longitude',
            'maximumAttendeeCapacity',
            'openingHours',
            'openingHoursSpecification',
            'paymentAccepted',
            'photo',
            'priceRange',
            'publicAccess',
            'smokingAllowed',
            'specialOpeningHoursSpecification',
        ];
    }
}
