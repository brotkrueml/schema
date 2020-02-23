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
 * The price asked for a given offer by the respective organization or person.
 */
final class UnitPriceSpecification extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'billingIncrement' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'eligibleQuantity' => null,
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
        'priceType' => null,
        'referenceQuantity' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'unitCode' => null,
        'unitText' => null,
        'url' => null,
        'validFrom' => null,
        'validThrough' => null,
        'valueAddedTaxIncluded' => null,
    ];
}
