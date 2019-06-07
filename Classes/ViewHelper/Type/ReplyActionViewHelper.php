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
 * The act of responding to a question/message asked/sent by the object. Related to AskAction
 *
 * schema.org version 3.6
 */
class ReplyActionViewHelper extends CommunicateActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('resultComment', 'mixed', 'A sub property of result. The Comment created or sent as a result of this action.');
    }
}
