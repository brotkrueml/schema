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
 * The act of gaining ownership of an object from an origin. Reciprocal of GiveAction.
 */
class TakeAction extends AbstractType
{
    use TypeTrait\TransferActionTrait;
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
}
