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
 * A tourist attraction.  In principle any Thing can be a TouristAttraction, from a Mountain and LandmarksOrHistoricalBuildings to a LocalBusiness.  This Type can be used on its own to describe a general TouristAttraction, or be used as an additionalType to add tourist attraction properties to any other type.  (See examples below)
 *
 * schema.org version 3.6
 */
class TouristAttraction extends Place
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('availableLanguage', 'touristType');
    }
}
