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
 * A product or service offered by a bank whereby one may deposit, withdraw or transfer money and in some cases be paid interest.
 */
final class BankAccount extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
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
