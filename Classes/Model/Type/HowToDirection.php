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
 * A direction indicating a single action to do in the instructions for how to achieve a result.
 */
class HowToDirection extends AbstractType
{
    use TypeTrait\HowToDirectionTrait;
    use TypeTrait\ListItemTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\CreativeWorkTrait;
}
