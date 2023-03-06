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
 * A compound price specification is one that bundles multiple prices that all apply in combination for different dimensions of consumption. Use the name property of the attached unit price specification for indicating the dimension of a price component (e.g. "electricity" or "final cleaning").
 */
#[Type('CompoundPriceSpecification')]
final class CompoundPriceSpecification extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
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
        'priceComponent',
        'priceCurrency',
        'priceType',
        'sameAs',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
        'valueAddedTaxIncluded',
    ];
}
