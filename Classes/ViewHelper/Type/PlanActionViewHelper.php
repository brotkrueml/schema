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
 * The act of planning the execution of an event/task/action/reservation/plan to a future date.
 *
 * schema.org version 3.6
 */
class PlanActionViewHelper extends OrganizeActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('scheduledTime', 'mixed', 'The time the object is scheduled to.');
    }
}
