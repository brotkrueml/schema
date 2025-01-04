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
 * An enumeration of several kinds of Map.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum MapCategoryType implements EnumerationInterface
{
    /**
     * A parking map.
     */
    case ParkingMap;

    /**
     * A seating map.
     */
    case SeatingMap;

    /**
     * A transit map.
     */
    case TransitMap;

    /**
     * A venue map (e.g. for malls, auditoriums, museums, etc.).
     */
    case VenueMap;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
