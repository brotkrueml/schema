<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class Recipe extends HowTo
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('cookTime', 'cookingMethod', 'nutrition', 'recipeCategory', 'recipeCuisine', 'recipeIngredient', 'recipeInstructions', 'recipeYield', 'suitableForDiet');
    }
}
