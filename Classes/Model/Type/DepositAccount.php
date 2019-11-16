<?php
declare(strict_types=1);

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
 * A type of Bank Account with a main purpose of depositing funds to gain interest or other benefits.
 */
final class DepositAccount extends AbstractType
{
    use TypeTrait\FinancialProductTrait;
    use TypeTrait\InvestmentOrDepositTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
