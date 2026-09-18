<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * ShippingService represents the criteria used to determine if and how an offer could be shipped to a customer.
 */
#[Type('ShippingService')]
#[Manual(Publisher::Google, 'Merchant shipping policy', 'https://developers.google.com/search/docs/appearance/structured-data/shipping-policy#merchant-shipping-policy-properties')]
final class ShippingService extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'fulfillmentType',
        'handlingTime',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'shippingConditions',
        'subjectOf',
        'url',
        'validForMemberTier',
    ];
}
