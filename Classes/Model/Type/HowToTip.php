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
 * An explanation in the instructions for how to achieve a result. It provides supplementary information about a technique, supply, author\&#039;s preference, etc. It can explain what could be done, or what should not be done, but doesn\&#039;t specify what should be done (see HowToDirection).
 */
class HowToTip extends AbstractType
{
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\ListItemTrait;
    use TypeTrait\ThingTrait;
}
