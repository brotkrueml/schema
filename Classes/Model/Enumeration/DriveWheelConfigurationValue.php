<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * A value indicating which roadwheels will receive torque.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum DriveWheelConfigurationValue implements EnumerationInterface
{
    /**
     * All-wheel Drive is a transmission layout where the engine drives all four wheels.
     */
    case AllWheelDriveConfiguration;

    /**
     * Four-wheel drive is a transmission layout where the engine primarily drives two wheels with a part-time four-wheel drive capability.
     */
    case FourWheelDriveConfiguration;

    /**
     * Front-wheel drive is a transmission layout where the engine drives the front wheels.
     */
    case FrontWheelDriveConfiguration;

    /**
     * Real-wheel drive is a transmission layout where the engine drives the rear wheels.
     */
    case RearWheelDriveConfiguration;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
