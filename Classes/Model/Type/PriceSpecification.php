<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A structured value representing a price or price range. Typically, only the subclasses of this type are used for markup. It is recommended to use MonetaryAmount to describe independent amounts of money such as a salary, credit card limits, etc.
 *
 * schema.org version 3.6
 */
class PriceSpecification extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('eligibleQuantity', 'eligibleTransactionVolume', 'maxPrice', 'minPrice', 'price', 'priceCurrency', 'validFrom', 'validThrough', 'valueAddedTaxIncluded');
    }
}
