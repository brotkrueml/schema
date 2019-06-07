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
 * The act of ingesting information/resources/food.
 *
 * schema.org version 3.6
 */
class ConsumeActionViewHelper extends ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actionAccessibilityRequirement', 'mixed', 'A set of requirements that a must be fulfilled in order to perform an Action. If more than one value is specied, fulfilling one set of requirements will allow the Action to be performed.');
        $this->registerArgument('expectsAcceptanceOf', 'mixed', 'An Offer which must be accepted before the user can perform the Action. For example, the user may need to buy a movie before being able to watch it.');
    }
}
