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
 * An agent leaves an event / group with participants/friends at a location.
 *
 * schema.org version 3.6
 */
class LeaveActionViewHelper extends InteractActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('event', 'mixed', 'Upcoming or past event associated with this place, organization, or action.');
    }
}
