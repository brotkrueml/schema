<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Model\Type\Physician;

/**
 * The following properties have been removed with
 * schema.org version 24.0.
 * These properties are registered again to avoid
 * breaking changes in minor EXT:schema releases.
 *
 * @see https://github.com/schemaorg/schemaorg/pull/3427
 * @todo Remove with schema 4.0.0
 * @internal
 */
final class RegisterRemovedTypePropertiesForPhysician
{
    /**
     * @var list<string>
     */
    private const PROPERTIES = [
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

    public function __invoke(RegisterAdditionalTypePropertiesEvent $event): void
    {
        if ($event->getType() === Physician::class) {
            \array_map($event->registerAdditionalProperty(...), self::PROPERTIES);
        }
    }
}
