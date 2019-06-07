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
 * A CampingPitch is an individual place for overnight stay in the outdoors, typically being part of a larger camping site, or Campground.
 *
 * schema.org version 3.6
 */
class CampingPitch extends Accommodation
{
    public function __construct()
    {
        parent::__construct();
    }
}
