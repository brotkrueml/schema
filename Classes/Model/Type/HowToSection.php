<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A sub-grouping of steps in the instructions for how to achieve a result (e.g. steps for making a pie crust within a pie recipe).
 */
class HowToSection extends AbstractType
{
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\ItemListTrait;
    use TypeTrait\ListItemTrait;
    use TypeTrait\ThingTrait;
}
