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
 * A recipe. For dietary restrictions covered by the recipe, a few common restrictions are enumerated via suitableForDiet. The keywords property can also be used to add more detail.
 *
 * schema.org version 3.6
 */
class RecipeViewHelper extends HowToViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('cookTime', 'mixed', 'The time it takes to actually cook the dish, in ISO 8601 duration format.');
        $this->registerArgument('cookingMethod', 'mixed', 'The method of cooking, such as Frying, Steaming, ...');
        $this->registerArgument('nutrition', 'mixed', 'Nutrition information about the recipe or menu item.');
        $this->registerArgument('recipeCategory', 'mixed', 'The category of the recipe—for example, appetizer, entree, etc.');
        $this->registerArgument('recipeCuisine', 'mixed', 'The cuisine of the recipe (for example, French or Ethiopian).');
        $this->registerArgument('recipeIngredient', 'mixed', 'A single ingredient used in the recipe, e.g. sugar, flour or garlic.');
        $this->registerArgument('recipeInstructions', 'mixed', 'A step in making the recipe, in the form of a single item (document, video, etc.) or an ordered list with HowToStep and/or HowToSection items.');
        $this->registerArgument('recipeYield', 'mixed', 'The quantity produced by the recipe (for example, number of people served, number of servings, etc).');
        $this->registerArgument('suitableForDiet', 'mixed', 'Indicates a dietary restriction or guideline for which this recipe or menu item is suitable, e.g. diabetic, halal etc.');
    }
}
