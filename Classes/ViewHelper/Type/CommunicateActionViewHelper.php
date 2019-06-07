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
 * The act of conveying information to another person via a communication medium (instrument) such as speech, email, or telephone conversation.
 *
 * schema.org version 3.6
 */
class CommunicateActionViewHelper extends InteractActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('about', 'mixed', 'The subject matter of the content.');
        $this->registerArgument('inLanguage', 'mixed', 'The language of the content or performance or used in an action. Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage.');
        $this->registerArgument('recipient', 'mixed', 'A sub property of participant. The participant who is at the receiving end of the action.');
    }
}
