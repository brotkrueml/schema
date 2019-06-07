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
 * The act of notifying an event organizer as to whether you expect to attend the event.
 *
 * schema.org version 3.6
 */
class RsvpActionViewHelper extends InformActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalNumberOfGuests', 'mixed', 'If responding yes, the number of guests who will attend in addition to the invitee.');
        $this->registerArgument('comment', 'mixed', 'Comments, typically from users.');
        $this->registerArgument('rsvpResponse', 'mixed', 'The response (yes, no, maybe) to the RSVP.');
    }
}
