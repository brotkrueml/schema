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
 * The act of responding to a question/message asked/sent by the object. Related to AskAction
 *
 * schema.org version 3.6
 */
class ReplyAction extends CommunicateAction
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('resultComment');
    }
}
