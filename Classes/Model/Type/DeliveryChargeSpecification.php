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
 * The price for the delivery of an offer using a particular delivery method.
 */
final class DeliveryChargeSpecification extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'appliesToDeliveryMethod' => null,
        'areaServed' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'eligibleQuantity' => null,
        'eligibleRegion' => null,
        'eligibleTransactionVolume' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'maxPrice' => null,
        'minPrice' => null,
        'name' => null,
        'potentialAction' => null,
        'price' => null,
        'priceCurrency' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
        'validFrom' => null,
        'validThrough' => null,
        'valueAddedTaxIncluded' => null,
    ];
}
