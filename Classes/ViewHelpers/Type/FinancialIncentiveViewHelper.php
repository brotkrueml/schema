<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * Represents financial incentives for goods/services offered by an organization (or individual).
 *
 * Typically contains the name of the incentive, the incentivizedItem, the incentiveAmount, the incentiveStatus, incentiveType, the provider of the incentive, and eligibleWithSupplier.
 *
 * Optionally contains criteria on whether the incentive is limited based on purchaseType, purchasePriceLimit, incomeLimit, and the qualifiedExpense.
 */
final class FinancialIncentiveViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'FinancialIncentive';
}
