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
 * A structured value representing a price or price range. Typically, only the subclasses of this type are used for markup. It is recommended to use MonetaryAmount to describe independent amounts of money such as a salary, credit card limits, etc.
 */
final class PriceSpecification extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
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
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
        'validFrom' => null,
        'validThrough' => null,
        'valueAddedTaxIncluded' => null,
    ];
}
