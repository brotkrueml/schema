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
 * Nutritional information about the recipe.
 *
 * schema.org version 3.6
 */
class NutritionInformationViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('calories', 'mixed', 'The number of calories.');
        $this->registerArgument('carbohydrateContent', 'mixed', 'The number of grams of carbohydrates.');
        $this->registerArgument('cholesterolContent', 'mixed', 'The number of milligrams of cholesterol.');
        $this->registerArgument('fatContent', 'mixed', 'The number of grams of fat.');
        $this->registerArgument('fiberContent', 'mixed', 'The number of grams of fiber.');
        $this->registerArgument('proteinContent', 'mixed', 'The number of grams of protein.');
        $this->registerArgument('saturatedFatContent', 'mixed', 'The number of grams of saturated fat.');
        $this->registerArgument('servingSize', 'mixed', 'The serving size, in terms of the number of volume or mass.');
        $this->registerArgument('sodiumContent', 'mixed', 'The number of milligrams of sodium.');
        $this->registerArgument('sugarContent', 'mixed', 'The number of grams of sugar.');
        $this->registerArgument('transFatContent', 'mixed', 'The number of grams of trans fat.');
        $this->registerArgument('unsaturatedFatContent', 'mixed', 'The number of grams of unsaturated fat.');
    }
}
