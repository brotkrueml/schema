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
 * An agent pays a price to a participant.
 *
 * schema.org version 3.6
 */
class PayActionViewHelper extends TradeActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('recipient', 'mixed', 'A sub property of participant. The participant who is at the receiving end of the action.');
    }
}
