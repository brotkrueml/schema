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
 * The act of expressing a preference from a set of options or a large or unbounded set of choices/options.
 *
 * schema.org version 3.6
 */
class ChooseActionViewHelper extends AssessActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actionOption', 'mixed', 'A sub property of object. The options subject to this action.');
    }
}
