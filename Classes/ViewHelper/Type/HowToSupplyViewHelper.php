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
 * A supply consumed when performing the instructions for how to achieve a result.
 *
 * schema.org version 3.6
 */
class HowToSupplyViewHelper extends HowToItemViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('estimatedCost', 'mixed', 'The estimated cost of the supply or supplies consumed when performing instructions.');
    }
}
