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
 * A FloorPlan is an explicit representation of a collection of similar accommodations, allowing the provision of common information (room counts, sizes, layout diagrams) and offers for rental or sale. In typical use, some ApartmentComplex has an accommodationFloorPlan which is a FloorPlan.  A FloorPlan is always in the context of a particular place, either a larger ApartmentComplex or a single Apartment. The visual/spatial aspects of a floor plan (i.e. room layout, [see wikipedia](https://en.wikipedia.org/wiki/Floor_plan)) can be indicated using image.
 */
#[Type('FloorPlan')]
final class FloorPlan extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'amenityFeature',
        'description',
        'disambiguatingDescription',
        'floorSize',
        'identifier',
        'image',
        'isPlanForApartment',
        'layoutImage',
        'mainEntityOfPage',
        'name',
        'numberOfAccommodationUnits',
        'numberOfAvailableAccommodationUnits',
        'numberOfBathroomsTotal',
        'numberOfBedrooms',
        'numberOfFullBathrooms',
        'numberOfPartialBathrooms',
        'numberOfRooms',
        'owner',
        'petsAllowed',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
