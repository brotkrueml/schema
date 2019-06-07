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
 * One of the continents (for example, Europe or Africa).
 *
 * schema.org version 3.6
 */
class Continent extends Landform
{
    public function __construct()
    {
        parent::__construct();
    }
}
