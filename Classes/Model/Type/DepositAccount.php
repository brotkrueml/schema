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
 * A type of Bank Account with a main purpose of depositing funds to gain interest or other benefits.
 */
#[Type('DepositAccount')]
final class DepositAccount extends AbstractType
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
        'description',
        'disambiguatingDescription',
        'feesAndCommissionsSpecification',
        'hasCertification',
        'hasOfferCatalog',
        'hoursAvailable',
        'identifier',
        'image',
        'interestRate',
        'isRelatedTo',
        'isSimilarTo',
        'logo',
        'mainEntityOfPage',
        'name',
        'offers',
        'potentialAction',
        'providerMobility',
        'review',
        'sameAs',
        'serviceOutput',
        'serviceType',
        'slogan',
        'subjectOf',
        'url',
    ];
}
