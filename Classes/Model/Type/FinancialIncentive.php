<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * Represents financial incentives for goods/services offered by an organization (or individual).
 *
 * Typically contains the name of the incentive, the incentivizedItem, the incentiveAmount, the incentiveStatus, incentiveType, the provider of the incentive, and eligibleWithSupplier.
 *
 * Optionally contains criteria on whether the incentive is limited based on purchaseType, purchasePriceLimit, incomeLimit, and the qualifiedExpense.
 */
#[Type('FinancialIncentive')]
final class FinancialIncentive extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'areaServed',
        'description',
        'disambiguatingDescription',
        'eligibleWithSupplier',
        'identifier',
        'image',
        'incentiveAmount',
        'incentiveStatus',
        'incentiveType',
        'incentivizedItem',
        'incomeLimit',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'provider',
        'publisher',
        'purchasePriceLimit',
        'purchaseType',
        'qualifiedExpense',
        'sameAs',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
    ];
}
