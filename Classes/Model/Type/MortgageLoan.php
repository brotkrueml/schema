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
 * A loan in which property or real estate is used as collateral. (A loan securitized against some real estate.)
 */
#[Type('MortgageLoan')]
final class MortgageLoan extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'aggregateRating',
        'alternateName',
        'amount',
        'annualPercentageRate',
        'areaServed',
        'audience',
        'availableChannel',
        'award',
        'brand',
        'broker',
        'category',
        'currency',
        'description',
        'disambiguatingDescription',
        'domiciledMortgage',
        'feesAndCommissionsSpecification',
        'gracePeriod',
        'hasCertification',
        'hasOfferCatalog',
        'hoursAvailable',
        'identifier',
        'image',
        'interestRate',
        'isRelatedTo',
        'isSimilarTo',
        'loanMortgageMandateAmount',
        'loanRepaymentForm',
        'loanTerm',
        'loanType',
        'logo',
        'mainEntityOfPage',
        'name',
        'offers',
        'owner',
        'potentialAction',
        'provider',
        'providerMobility',
        'recourseLoan',
        'renegotiableLoan',
        'requiredCollateral',
        'review',
        'sameAs',
        'serviceOutput',
        'serviceType',
        'slogan',
        'subjectOf',
        'termsOfService',
        'url',
    ];
}
