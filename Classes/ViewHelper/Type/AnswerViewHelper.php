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
 * An answer offered to a question; perhaps correct, perhaps opinionated or wrong.
 *
 * schema.org version 3.6
 */
class AnswerViewHelper extends CommentViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
