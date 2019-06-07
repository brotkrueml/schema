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
 * An item used as either a tool or supply when performing the instructions for how to to achieve a result.
 *
 * schema.org version 3.6
 */
class HowToItem extends ListItem
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('requiredQuantity');
    }
}
