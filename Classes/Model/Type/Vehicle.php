<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A vehicle is a device that is designed or used to transport people or cargo over land, water, air, or through space.
 *
 * schema.org version 3.6
 */
class Vehicle extends Product
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('cargoVolume', 'dateVehicleFirstRegistered', 'driveWheelConfiguration', 'fuelConsumption', 'fuelEfficiency', 'fuelType', 'knownVehicleDamages', 'mileageFromOdometer', 'numberOfAirbags', 'numberOfAxles', 'numberOfDoors', 'numberOfForwardGears', 'numberOfPreviousOwners', 'steeringPosition', 'vehicleConfiguration', 'vehicleEngine', 'vehicleIdentificationNumber', 'vehicleInteriorColor', 'vehicleInteriorType', 'vehicleModelDate', 'vehicleSeatingCapacity', 'vehicleTransmission');
    }
}
