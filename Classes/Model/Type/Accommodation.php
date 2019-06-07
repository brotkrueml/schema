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
 * An accommodation is a place that can accommodate human beings, e.g. a hotel room, a camping pitch, or a meeting room. Many accommodations are for overnight stays, but this is not a mandatory requirement.
 *
 * schema.org version 3.6
 */
class Accommodation extends Place
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('floorSize', 'numberOfRooms', 'permittedUsage', 'petsAllowed');
    }
}
