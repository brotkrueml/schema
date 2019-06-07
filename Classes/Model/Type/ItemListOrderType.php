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
 * Enumerated for values for itemListOrder for indicating how an ordered ItemList is organized.
 *
 * schema.org version 3.6
 */
class ItemListOrderType extends Enumeration
{
    public function __construct()
    {
        parent::__construct();
    }
}
