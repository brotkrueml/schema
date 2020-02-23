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

/**
 * A type of Bank Account with a main purpose of depositing funds to gain interest or other benefits.
 */
final class DepositAccount extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'amount' => null,
        'annualPercentageRate' => null,
        'areaServed' => null,
        'audience' => null,
        'availableChannel' => null,
        'award' => null,
        'brand' => null,
        'broker' => null,
        'category' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'feesAndCommissionsSpecification' => null,
        'hasOfferCatalog' => null,
        'hoursAvailable' => null,
        'identifier' => null,
        'image' => null,
        'interestRate' => null,
        'isRelatedTo' => null,
        'isSimilarTo' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'offers' => null,
        'potentialAction' => null,
        'provider' => null,
        'providerMobility' => null,
        'review' => null,
        'sameAs' => null,
        'serviceOutput' => null,
        'serviceType' => null,
        'slogan' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
