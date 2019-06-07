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
 * A single message from a sender to one or more organizations or people.
 *
 * schema.org version 3.6
 */
class MessageViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('bccRecipient', 'mixed', 'A sub property of recipient. The recipient blind copied on a message.');
        $this->registerArgument('ccRecipient', 'mixed', 'A sub property of recipient. The recipient copied on a message.');
        $this->registerArgument('dateRead', 'mixed', 'The date/time at which the message has been read by the recipient if a single recipient exists.');
        $this->registerArgument('dateReceived', 'mixed', 'The date/time the message was received if a single recipient exists.');
        $this->registerArgument('dateSent', 'mixed', 'The date/time at which the message was sent.');
        $this->registerArgument('messageAttachment', 'mixed', 'A CreativeWork attached to the message.');
        $this->registerArgument('recipient', 'mixed', 'A sub property of participant. The participant who is at the receiving end of the action.');
        $this->registerArgument('sender', 'mixed', 'A sub property of participant. The participant who is at the sending end of the action.');
        $this->registerArgument('toRecipient', 'mixed', 'A sub property of recipient. The recipient who was directly sent the message.');
    }
}
