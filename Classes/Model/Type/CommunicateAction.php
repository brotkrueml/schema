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
 * The act of conveying information to another person via a communication medium (instrument) such as speech, email, or telephone conversation.
 *
 * schema.org version 3.6
 */
class CommunicateAction extends InteractAction
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('about', 'inLanguage', 'recipient');
    }
}
