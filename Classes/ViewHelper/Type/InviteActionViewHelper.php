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
 * The act of asking someone to attend an event. Reciprocal of RsvpAction.
 *
 * schema.org version 3.6
 */
class InviteActionViewHelper extends CommunicateActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('event', 'mixed', 'Upcoming or past event associated with this place, organization, or action.');
    }
}
