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
 * Enumerates common size systems specific for wearable products.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum WearableSizeSystemEnumeration implements EnumerationInterface
{
    /**
     * Australian size system for wearables.
     */
    case WearableSizeSystemAU;

    /**
     * Brazilian size system for wearables.
     */
    case WearableSizeSystemBR;

    /**
     * Chinese size system for wearables.
     */
    case WearableSizeSystemCN;

    /**
     * Continental size system for wearables.
     */
    case WearableSizeSystemContinental;

    /**
     * German size system for wearables.
     */
    case WearableSizeSystemDE;

    /**
     * EN 13402 (joint European standard for size labelling of clothes).
     */
    case WearableSizeSystemEN13402;

    /**
     * European size system for wearables.
     */
    case WearableSizeSystemEurope;

    /**
     * French size system for wearables.
     */
    case WearableSizeSystemFR;

    /**
     * GS1 (formerly NRF) size system for wearables.
     */
    case WearableSizeSystemGS1;

    /**
     * Italian size system for wearables.
     */
    case WearableSizeSystemIT;

    /**
     * Japanese size system for wearables.
     */
    case WearableSizeSystemJP;

    /**
     * Mexican size system for wearables.
     */
    case WearableSizeSystemMX;

    /**
     * United Kingdom size system for wearables.
     */
    case WearableSizeSystemUK;

    /**
     * United States size system for wearables.
     */
    case WearableSizeSystemUS;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
