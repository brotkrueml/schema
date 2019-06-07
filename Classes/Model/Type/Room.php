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
 * A room is a distinguishable space within a structure, usually separated from other spaces by interior walls. (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Room).
 *
 * schema.org version 3.6
 */
class Room extends Accommodation
{
    public function __construct()
    {
        parent::__construct();
    }
}
