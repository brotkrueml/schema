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
 * A sub-grouping of food or drink items in a menu. E.g. courses (such as \'Dinner\', \'Breakfast\', etc.), specific type of dishes (such as \'Meat\', \'Vegan\', \'Drinks\', etc.), or some other classification made by the menu provider.
 *
 * schema.org version 3.6
 */
class MenuSectionViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('hasMenuItem', 'mixed', 'A food or drink item contained in a menu or menu section.');
        $this->registerArgument('hasMenuSection', 'mixed', 'A subgrouping of the menu (by dishes, course, serving time period, etc.).');
    }
}
