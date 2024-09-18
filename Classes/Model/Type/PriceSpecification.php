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
 * A structured value representing a price or price range. Typically, only the subclasses of this type are used for markup. It is recommended to use MonetaryAmount to describe independent amounts of money such as a salary, credit card limits, etc.
 */
#[Type('PriceSpecification')]
final class PriceSpecification extends AbstractType
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
        'priceCurrency',
        'sameAs',
        'subjectOf',
        'url',
        'validForMemberTier',
        'validFrom',
        'validThrough',
        'valueAddedTaxIncluded',
    ];
}
