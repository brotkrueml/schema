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
 * Natural languages such as Spanish, Tamil, Hindi, English, etc. Formal language code tags expressed in BCP 47 can be used via the alternateName property. The Language type previously also covered programming languages such as Scheme and Lisp, which are now best represented using ComputerLanguage.
 *
 * schema.org version 3.6
 */
class LanguageViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
