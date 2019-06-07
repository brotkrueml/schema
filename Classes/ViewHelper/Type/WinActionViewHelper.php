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
 * The act of achieving victory in a competitive activity.
 *
 * schema.org version 3.6
 */
class WinActionViewHelper extends AchieveActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('loser', 'mixed', 'A sub property of participant. The loser of the action.');
    }
}
