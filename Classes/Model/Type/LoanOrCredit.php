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
 * A financial product for the loaning of an amount of money under agreed terms and charges.
 */
class LoanOrCredit extends AbstractType
{
    use TypeTrait\FinancialProductTrait;
    use TypeTrait\LoanOrCreditTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
