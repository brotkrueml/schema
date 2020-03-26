<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * The price for the delivery of an offer using a particular delivery method.
 */
final class DeliveryChargeSpecification extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'appliesToDeliveryMethod',
        'areaServed',
        'description',
        'disambiguatingDescription',
        'eligibleQuantity',
        'eligibleRegion',
        'eligibleTransactionVolume',
        'identifier',
        'image',
        'mainEntityOfPage',
        'maxPrice',
        'minPrice',
        'name',
        'potentialAction',
        'price',
        'priceCurrency',
        'sameAs',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
        'valueAddedTaxIncluded',
    ];
}
