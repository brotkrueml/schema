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
 * A winery.
 *
 * schema.org version 3.6
 */
class Winery extends FoodEstablishment
{
    public function __construct()
    {
        parent::__construct();
    }
}
