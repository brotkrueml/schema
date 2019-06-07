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
 * The act of participating in performance arts.
 *
 * schema.org version 3.6
 */
class PerformActionViewHelper extends PlayActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('entertainmentBusiness', 'mixed', 'A sub property of location. The entertainment business where the action occurred.');
    }
}
