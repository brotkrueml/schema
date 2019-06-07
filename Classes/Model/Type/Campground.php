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
 * A camping site, campsite, or Campground is a place used for overnight stay in the outdoors, typically containing individual CampingPitch locations.
 *
 * schema.org version 3.6
 */
class Campground extends CivicStructure
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('amenityFeature', 'audience', 'availableLanguage', 'checkinTime', 'checkoutTime', 'numberOfRooms', 'petsAllowed', 'starRating');
    }
}
