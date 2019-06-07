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
 * The act of physically/electronically taking delivery of an object thathas been transferred from an origin to a destination. Reciprocal of SendAction.
 *
 * schema.org version 3.6
 */
class ReceiveActionViewHelper extends TransferActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('deliveryMethod', 'mixed', 'A sub property of instrument. The method of delivery.');
        $this->registerArgument('sender', 'mixed', 'A sub property of participant. The participant who is at the sending end of the action.');
    }
}
