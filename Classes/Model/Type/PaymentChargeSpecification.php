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
 * The costs of settling the payment using a particular payment method.
 */
final class PaymentChargeSpecification extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'appliesToDeliveryMethod' => null,
        'appliesToPaymentMethod' => null,
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
