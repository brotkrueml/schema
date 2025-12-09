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
 * A card payment method of a particular brand or name.  Used to mark up a particular payment method and/or the financial product/service that supplies the card account.
 *
 * Commonly used values:
 * http://purl.org/goodrelations/v1#AmericanExpress
 * http://purl.org/goodrelations/v1#DinersClub
 * http://purl.org/goodrelations/v1#Discover
 * http://purl.org/goodrelations/v1#JCB
 * http://purl.org/goodrelations/v1#MasterCard
 * http://purl.org/goodrelations/v1#VISA
 */
#[Type('CreditCard')]
final class CreditCard extends AbstractType
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
        'hasCertification',
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
        'owner',
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
