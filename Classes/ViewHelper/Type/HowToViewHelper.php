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
 * Instructions that explain how to achieve a result by performing a sequence of steps.
 *
 * schema.org version 3.6
 */
class HowToViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('estimatedCost', 'mixed', 'The estimated cost of the supply or supplies consumed when performing instructions.');
        $this->registerArgument('performTime', 'mixed', 'The length of time it takes to perform instructions or a direction (not including time to prepare the supplies), in ISO 8601 duration format.');
        $this->registerArgument('prepTime', 'mixed', 'The length of time it takes to prepare the items to be used in instructions or a direction, in ISO 8601 duration format.');
        $this->registerArgument('step', 'mixed', 'A single step item (as HowToStep, text, document, video, etc.) or a HowToSection.');
        $this->registerArgument('supply', 'mixed', 'A sub-property of instrument. A supply consumed when performing instructions or a direction.');
        $this->registerArgument('tool', 'mixed', 'A sub property of instrument. An object used (but not consumed) when performing instructions or a direction.');
        $this->registerArgument('totalTime', 'mixed', 'The total time required to perform instructions or a direction (including time to prepare the supplies), in ISO 8601 duration format.');
        $this->registerArgument('yield', 'mixed', 'The quantity that results by performing instructions. For example, a paper airplane, 10 personalized candles.');
    }
}
