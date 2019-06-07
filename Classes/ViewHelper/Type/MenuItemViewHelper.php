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
 * A food or drink item listed in a menu or menu section.
 *
 * schema.org version 3.6
 */
class MenuItemViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('menuAddOn', 'mixed', 'Additional menu item(s) such as a side dish of salad or side order of fries that can be added to this menu item. Additionally it can be a menu section containing allowed add-on menu items for this menu item.');
        $this->registerArgument('nutrition', 'mixed', 'Nutrition information about the recipe or menu item.');
        $this->registerArgument('offers', 'mixed', 'An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.');
        $this->registerArgument('suitableForDiet', 'mixed', 'Indicates a dietary restriction or guideline for which this recipe or menu item is suitable, e.g. diabetic, halal etc.');
    }
}
