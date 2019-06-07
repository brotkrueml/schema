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
 * The act of expressing a negative sentiment about the object. An agent dislikes an object (a proposition, topic or theme) with participants.
 *
 * schema.org version 3.6
 */
class DislikeActionViewHelper extends ReactActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
