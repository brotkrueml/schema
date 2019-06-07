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
 * The act of transferring/moving (abstract or concrete) animate or inanimate objects from one place to another.
 *
 * schema.org version 3.6
 */
class TransferActionViewHelper extends ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('fromLocation', 'mixed', 'A sub property of location. The original location of the object or the agent before the action.');
        $this->registerArgument('toLocation', 'mixed', 'A sub property of location. The final location of the object or the agent after the action.');
    }
}
