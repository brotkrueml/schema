<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

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
class VehicleViewHelper extends ProductViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('cargoVolume', 'mixed', 'The available volume for cargo or luggage. For automobiles, this is usually the trunk volume.');
        $this->registerArgument('dateVehicleFirstRegistered', 'mixed', 'The date of the first registration of the vehicle with the respective public authorities.');
        $this->registerArgument('driveWheelConfiguration', 'mixed', 'The drive wheel configuration, i.e. which roadwheels will receive torque from the vehicle\'s engine via the drivetrain.');
        $this->registerArgument('fuelConsumption', 'mixed', 'The amount of fuel consumed for traveling a particular distance or temporal duration with the given vehicle (e.g. liters per 100 km).');
        $this->registerArgument('fuelEfficiency', 'mixed', 'The distance traveled per unit of fuel used; most commonly miles per gallon (mpg) or kilometers per liter (km/L).');
        $this->registerArgument('fuelType', 'mixed', 'The type of fuel suitable for the engine or engines of the vehicle. If the vehicle has only one engine, this property can be attached directly to the vehicle.');
        $this->registerArgument('knownVehicleDamages', 'mixed', 'A textual description of known damages, both repaired and unrepaired.');
        $this->registerArgument('mileageFromOdometer', 'mixed', 'The total distance travelled by the particular vehicle since its initial production, as read from its odometer.');
        $this->registerArgument('numberOfAirbags', 'mixed', 'The number or type of airbags in the vehicle.');
        $this->registerArgument('numberOfAxles', 'mixed', 'The number of axles.');
        $this->registerArgument('numberOfDoors', 'mixed', 'The number of doors.');
        $this->registerArgument('numberOfForwardGears', 'mixed', 'The total number of forward gears available for the transmission system of the vehicle.');
        $this->registerArgument('numberOfPreviousOwners', 'mixed', 'The number of owners of the vehicle, including the current one.');
        $this->registerArgument('steeringPosition', 'mixed', 'The position of the steering wheel or similar device (mostly for cars).');
        $this->registerArgument('vehicleConfiguration', 'mixed', 'A short text indicating the configuration of the vehicle, e.g. \'5dr hatchback ST 2.5 MT 225 hp\' or \'limited edition\'.');
        $this->registerArgument('vehicleEngine', 'mixed', 'Information about the engine or engines of the vehicle.');
        $this->registerArgument('vehicleIdentificationNumber', 'mixed', 'The Vehicle Identification Number (VIN) is a unique serial number used by the automotive industry to identify individual motor vehicles.');
        $this->registerArgument('vehicleInteriorColor', 'mixed', 'The color or color combination of the interior of the vehicle.');
        $this->registerArgument('vehicleInteriorType', 'mixed', 'The type or material of the interior of the vehicle (e.g. synthetic fabric, leather, wood, etc.). While most interior types are characterized by the material used, an interior type can also be based on vehicle usage or target audience.');
        $this->registerArgument('vehicleModelDate', 'mixed', 'The release date of a vehicle model (often used to differentiate versions of the same make and model).');
        $this->registerArgument('vehicleSeatingCapacity', 'mixed', 'The number of passengers that can be seated in the vehicle, both in terms of the physical space available, and in terms of limitations set by law.');
        $this->registerArgument('vehicleTransmission', 'mixed', 'The type of component used for transmitting the power from a rotating power source to the wheels or other relevant component(s) ("gearbox" for cars).');
    }
}
