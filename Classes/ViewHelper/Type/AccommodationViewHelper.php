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
 * An accommodation is a place that can accommodate human beings, e.g. a hotel room, a camping pitch, or a meeting room. Many accommodations are for overnight stays, but this is not a mandatory requirement.
 *
 * schema.org version 3.6
 */
class AccommodationViewHelper extends PlaceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('floorSize', 'mixed', 'The size of the accommodation, e.g. in square meter or squarefoot.');
        $this->registerArgument('numberOfRooms', 'mixed', 'The number of rooms (excluding bathrooms and closets) of the accommodation or lodging business.');
        $this->registerArgument('permittedUsage', 'mixed', 'Indications regarding the permitted usage of the accommodation.');
        $this->registerArgument('petsAllowed', 'mixed', 'Indicates whether pets are allowed to enter the accommodation or lodging business. More detailed information can be put in a text value.');
    }
}
