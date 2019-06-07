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
 * Instructions that explain how to achieve a result by performing a sequence of steps.
 *
 * schema.org version 3.6
 */
class HowTo extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('estimatedCost', 'performTime', 'prepTime', 'step', 'supply', 'tool', 'totalTime', 'yield');
    }
}
