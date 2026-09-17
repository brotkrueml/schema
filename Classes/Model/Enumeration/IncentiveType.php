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
 * Enumerates common financial incentives for products, including tax credits, tax deductions, rebates and subsidies, etc.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum IncentiveType implements EnumerationInterface
{
    /**
     * An incentive where the recipient can receive additional funding for the purchase/lease of the good/service, which must be paid back.
     */
    case IncentiveTypeLoan;

    /**
     * An incentive that reduces the purchase/lease cost of the good/service in question.
     */
    case IncentiveTypeRebateOrSubsidy;

    /**
     * An incentive that directly reduces the amount of tax owed by the recipient.
     */
    case IncentiveTypeTaxCredit;

    /**
     * An incentive that reduces the recipient's amount of taxable income.
     */
    case IncentiveTypeTaxDeduction;

    /**
     * An incentive that reduces/exempts the recipient from taxation applicable to the incentivized good/service (e.g. luxury taxes, registration taxes, circulation tax).
     */
    case IncentiveTypeTaxWaiver;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
