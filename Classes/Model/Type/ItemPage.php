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
 * A page devoted to a single item, such as a particular product or hotel.
 *
 * schema.org version 3.6
 */
class ItemPage extends WebPage
{
    public function __construct()
    {
        parent::__construct();
    }
}
