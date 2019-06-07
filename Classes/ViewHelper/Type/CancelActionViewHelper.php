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
 * The act of asserting that a future event/action is no longer going to happen.
 *
 * schema.org version 3.6
 */
class CancelActionViewHelper extends PlanActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
