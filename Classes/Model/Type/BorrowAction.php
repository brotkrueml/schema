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
 * The act of obtaining an object under an agreement to return it at a later date. Reciprocal of LendAction.
 */
class BorrowAction extends AbstractType
{
    use TypeTrait\BorrowActionTrait;
    use TypeTrait\TransferActionTrait;
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
}
