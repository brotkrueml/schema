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
 * The price asked for a given offer by the respective organization or person.
 */
#[Type('UnitPriceSpecification')]
final class UnitPriceSpecification extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'billingIncrement',
        'description',
        'disambiguatingDescription',
        'eligibleQuantity',
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
        'priceType',
        'referenceQuantity',
        'sameAs',
        'subjectOf',
        'unitCode',
        'unitText',
        'url',
        'validFrom',
        'validThrough',
        'valueAddedTaxIncluded',
    ];
}
