<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\ViewHelpers\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A sub-grouping of food or drink items in a menu. E.g. courses (such as \&#039;Dinner\&#039;, \&#039;Breakfast\&#039;, etc.), specific type of dishes (such as \&#039;Meat\&#039;, \&#039;Vegan\&#039;, \&#039;Drinks\&#039;, etc.), or some other classification made by the menu provider.
 */
final class MenuSectionViewHelper extends AbstractTypeViewHelper
{
    protected static $typeModel = \Brotkrueml\Schema\Model\Type\MenuSection::class;
}
