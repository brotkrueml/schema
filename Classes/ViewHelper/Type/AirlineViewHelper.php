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
 * An organization that provides flights for passengers.
 *
 * schema.org version 3.6
 */
class AirlineViewHelper extends OrganizationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('boardingPolicy', 'mixed', 'The type of boarding policy used by the airline (e.g. zone-based or group-based).');
        $this->registerArgument('iataCode', 'mixed', 'IATA identifier for an airline or airport.');
    }
}
