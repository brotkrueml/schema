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
 * ShippingDeliveryTime provides various pieces of information about delivery times for shipping.
 */
#[Type('ShippingDeliveryTime')]
#[Manual(Publisher::Google, 'Merchant listing: Shipping details', 'https://developers.google.com/search/docs/appearance/structured-data/merchant-listing#product-with-shipping-example')]
final class ShippingDeliveryTime extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'businessDays',
        'cutoffTime',
        'description',
        'disambiguatingDescription',
        'handlingTime',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'transitTime',
        'url',
    ];
}
