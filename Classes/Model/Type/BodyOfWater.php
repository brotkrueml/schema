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
 * A body of water, such as a sea, ocean, or lake.
 *
 * schema.org version 3.6
 */
class BodyOfWater extends Landform
{
    public function __construct()
    {
        parent::__construct();
    }
}
