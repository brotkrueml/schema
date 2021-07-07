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
 * A vehicle is a device that is designed or used to transport people or cargo over land, water, air, or through space.
 */
final class Vehicle extends AbstractType
{
    protected static $propertyNames = [
        'additionalProperty',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'audience',
        'award',
        'brand',
        'cargoVolume',
        'category',
        'color',
        'countryOfOrigin',
        'dateVehicleFirstRegistered',
        'depth',
        'description',
        'disambiguatingDescription',
        'driveWheelConfiguration',
        'fuelConsumption',
        'fuelEfficiency',
        'fuelType',
        'gtin12',
        'gtin13',
        'gtin14',
        'gtin8',
        'height',
        'identifier',
        'image',
        'isAccessoryOrSparePartFor',
        'isConsumableFor',
        'isRelatedTo',
        'isSimilarTo',
        'isVariantOf',
        'itemCondition',
        'knownVehicleDamages',
        'logo',
        'mainEntityOfPage',
        'manufacturer',
        'material',
        'mileageFromOdometer',
        'model',
        'mpn',
        'name',
        'numberOfAirbags',
        'numberOfAxles',
        'numberOfDoors',
        'numberOfForwardGears',
        'numberOfPreviousOwners',
        'offers',
        'potentialAction',
        'productID',
        'productionDate',
        'purchaseDate',
        'releaseDate',
        'review',
        'sameAs',
        'sku',
        'slogan',
        'steeringPosition',
        'subjectOf',
        'url',
        'vehicleConfiguration',
        'vehicleEngine',
        'vehicleIdentificationNumber',
        'vehicleInteriorColor',
        'vehicleInteriorType',
        'vehicleModelDate',
        'vehicleSeatingCapacity',
        'vehicleTransmission',
        'weight',
        'width',
    ];
}
