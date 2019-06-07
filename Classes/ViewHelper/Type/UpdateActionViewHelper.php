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
 * The act of managing by changing/editing the state of the object.
 *
 * schema.org version 3.6
 */
class UpdateActionViewHelper extends ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('targetCollection', 'mixed', 'A sub property of object. The collection target of the action.');
    }
}
