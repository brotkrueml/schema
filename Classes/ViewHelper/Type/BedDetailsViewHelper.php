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
 * An entity holding detailed information about the available bed types, e.g. the quantity of twin beds for a hotel room. For the single case of just one bed of a certain type, you can use bed directly with a text. See also BedType (under development).
 *
 * schema.org version 3.6
 */
class BedDetailsViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('numberOfBeds', 'mixed', 'The quantity of the given bed type available in the HotelRoom, Suite, House, or Apartment.');
        $this->registerArgument('typeOfBed', 'mixed', 'The type of bed to which the BedDetail refers, i.e. the type of bed available in the quantity indicated by quantity.');
    }
}
