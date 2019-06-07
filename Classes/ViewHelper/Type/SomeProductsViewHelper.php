<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A placeholder for multiple similar products of the same kind.
 *
 * schema.org version 3.6
 */
class SomeProductsViewHelper extends ProductViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('inventoryLevel', 'mixed', 'The current approximate inventory level for the item or items.');
    }
}
