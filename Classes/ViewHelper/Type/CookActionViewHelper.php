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
 * The act of producing/preparing food.
 *
 * schema.org version 3.6
 */
class CookActionViewHelper extends CreateActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('foodEstablishment', 'mixed', 'A sub property of location. The specific food establishment where the action occurred.');
        $this->registerArgument('foodEvent', 'mixed', 'A sub property of location. The specific food event where the action occurred.');
        $this->registerArgument('recipe', 'mixed', 'A sub property of instrument. The recipe/instructions used to perform the action.');
    }
}
