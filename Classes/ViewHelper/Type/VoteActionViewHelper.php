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
 * The act of expressing a preference from a fixed/finite/structured set of choices/options.
 *
 * schema.org version 3.6
 */
class VoteActionViewHelper extends ChooseActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('candidate', 'mixed', 'A sub property of object. The candidate subject of this action.');
    }
}
