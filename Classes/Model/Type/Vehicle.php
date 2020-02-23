<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A vehicle is a device that is designed or used to transport people or cargo over land, water, air, or through space.
 */
final class Vehicle extends AbstractType
{
    protected $properties = [
        'additionalProperty' => null,
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'audience' => null,
        'award' => null,
        'brand' => null,
        'cargoVolume' => null,
        'category' => null,
        'color' => null,
        'dateVehicleFirstRegistered' => null,
        'depth' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'driveWheelConfiguration' => null,
        'fuelConsumption' => null,
        'fuelEfficiency' => null,
        'fuelType' => null,
        'gtin12' => null,
        'gtin13' => null,
        'gtin14' => null,
        'gtin8' => null,
        'height' => null,
        'identifier' => null,
        'image' => null,
        'isAccessoryOrSparePartFor' => null,
        'isConsumableFor' => null,
        'isRelatedTo' => null,
        'isSimilarTo' => null,
        'itemCondition' => null,
        'knownVehicleDamages' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'manufacturer' => null,
        'material' => null,
        'mileageFromOdometer' => null,
        'model' => null,
        'mpn' => null,
        'name' => null,
        'numberOfAirbags' => null,
        'numberOfAxles' => null,
        'numberOfDoors' => null,
        'numberOfForwardGears' => null,
        'numberOfPreviousOwners' => null,
        'offers' => null,
        'potentialAction' => null,
        'productID' => null,
        'productionDate' => null,
        'purchaseDate' => null,
        'releaseDate' => null,
        'review' => null,
        'sameAs' => null,
        'sku' => null,
        'slogan' => null,
        'steeringPosition' => null,
        'subjectOf' => null,
        'url' => null,
        'vehicleConfiguration' => null,
        'vehicleEngine' => null,
        'vehicleIdentificationNumber' => null,
        'vehicleInteriorColor' => null,
        'vehicleInteriorType' => null,
        'vehicleModelDate' => null,
        'vehicleSeatingCapacity' => null,
        'vehicleTransmission' => null,
        'weight' => null,
        'width' => null,
    ];
}
