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
 * A card payment method of a particular brand or name.  Used to mark up a particular payment method and/or the financial product/service that supplies the card account.
 */
final class CreditCard extends AbstractType
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
        'currency' => null,
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
        'loanTerm' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'offers' => null,
        'potentialAction' => null,
        'provider' => null,
        'providerMobility' => null,
        'requiredCollateral' => null,
        'review' => null,
        'sameAs' => null,
        'serviceOutput' => null,
        'serviceType' => null,
        'slogan' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
