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
 * A single message from a sender to one or more organizations or people.
 *
 * schema.org version 3.6
 */
class Message extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('bccRecipient', 'ccRecipient', 'dateRead', 'dateReceived', 'dateSent', 'messageAttachment', 'recipient', 'sender', 'toRecipient');
    }
}
