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
 * A list of items of any sort&#x2014;for example, Top 10 Movies About Weathermen, or Top 100 Party Songs. Not to be confused with HTML lists, which are often used only for formatting.
 *
 * schema.org version 3.6
 */
class ItemList extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('itemListElement', 'itemListOrder', 'numberOfItems');
    }
}
