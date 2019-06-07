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
 * A house is a building or structure that has the ability to be occupied for habitation by humans or other creatures (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/House).
 *
 * schema.org version 3.6
 */
class House extends Accommodation
{
    public function __construct()
    {
        parent::__construct();
    }
}
