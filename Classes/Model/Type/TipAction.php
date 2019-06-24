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
 * The act of giving money voluntarily to a beneficiary in recognition of services rendered.
 */
class TipAction extends AbstractType
{
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\TipActionTrait;
    use TypeTrait\TradeActionTrait;
}
