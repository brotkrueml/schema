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
 * A type of financial product that typically requires the client to transfer funds to a financial service in return for potential beneficial financial return.
 */
class InvestmentOrDeposit extends AbstractType
{
    use TypeTrait\InvestmentOrDepositTrait;
    use TypeTrait\FinancialProductTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
