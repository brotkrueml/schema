<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * The types of expenses that are covered by the incentive. For example some incentives are only for the goods (tangible items) but the services (labor) are excluded.
 */
enum IncentiveQualifiedExpenseType implements EnumerationInterface
{
    /**
     * This incentive applies to goods only.
     */
    case IncentiveQualifiedExpenseTypeGoodsOnly;

    /**
     * This incentive can apply to either goods or services (or both).
     */
    case IncentiveQualifiedExpenseTypeGoodsOrServices;

    /**
     * This incentive applies to services only.
     */
    case IncentiveQualifiedExpenseTypeServicesOnly;

    /**
     * This incentive applies to utility bills.
     */
    case IncentiveQualifiedExpenseTypeUtilityBill;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
