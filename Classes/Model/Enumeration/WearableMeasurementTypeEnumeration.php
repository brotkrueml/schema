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
 * Enumerates common types of measurement for wearables products.
 */
enum WearableMeasurementTypeEnumeration implements EnumerationInterface
{
    /**
     * Measurement of the back section, for example of a jacket.
     */
    case WearableMeasurementBack;

    /**
     * Measurement of the chest/bust section, for example of a suit.
     */
    case WearableMeasurementChestOrBust;

    /**
     * Measurement of the collar, for example of a shirt.
     */
    case WearableMeasurementCollar;

    /**
     * Measurement of the cup, for example of a bra.
     */
    case WearableMeasurementCup;

    /**
     * Measurement of the height, for example the heel height of a shoe.
     */
    case WearableMeasurementHeight;

    /**
     * Measurement of the hip section, for example of a skirt.
     */
    case WearableMeasurementHips;

    /**
     * Measurement of the inseam, for example of pants.
     */
    case WearableMeasurementInseam;

    /**
     * Represents the length, for example of a dress.
     */
    case WearableMeasurementLength;

    /**
     * Measurement of the outside leg, for example of pants.
     */
    case WearableMeasurementOutsideLeg;

    /**
     * Measurement of the sleeve length, for example of a shirt.
     */
    case WearableMeasurementSleeve;

    /**
     * Measurement of the waist section, for example of pants.
     */
    case WearableMeasurementWaist;

    /**
     * Measurement of the width, for example of shoes.
     */
    case WearableMeasurementWidth;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
