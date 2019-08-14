<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * The act of returning to the origin that which was previously received (concrete objects) or taken (ownership).
 */
final class ReturnAction extends AbstractType
{
    use TypeTrait\ActionTrait;
    use TypeTrait\ReturnActionTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\TransferActionTrait;
}
