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
 * A financial product for the loaning of an amount of money, or line of credit, under agreed terms and charges.
 */
#[Type('LoanOrCredit')]
final class LoanOrCredit extends AbstractType
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
        'feesAndCommissionsSpecification',
        'hasOfferCatalog',
        'hoursAvailable',
        'identifier',
        'image',
        'interestRate',
        'isRelatedTo',
        'isSimilarTo',
        'loanTerm',
        'logo',
        'mainEntityOfPage',
        'name',
        'offers',
        'potentialAction',
        'providerMobility',
        'requiredCollateral',
        'review',
        'sameAs',
        'serviceOutput',
        'serviceType',
        'slogan',
        'subjectOf',
        'url',
    ];
}
