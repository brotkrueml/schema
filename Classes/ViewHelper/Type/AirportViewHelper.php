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
 * An airport.
 *
 * schema.org version 3.6
 */
class AirportViewHelper extends CivicStructureViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('iataCode', 'mixed', 'IATA identifier for an airline or airport.');
        $this->registerArgument('icaoCode', 'mixed', 'ICAO identifier for an airport.');
    }
}
