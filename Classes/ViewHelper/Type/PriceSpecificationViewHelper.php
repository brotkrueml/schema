<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

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
class PriceSpecificationViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('eligibleQuantity', 'mixed', 'The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.');
        $this->registerArgument('eligibleTransactionVolume', 'mixed', 'The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.');
        $this->registerArgument('maxPrice', 'mixed', 'The highest price if the price is a range.');
        $this->registerArgument('minPrice', 'mixed', 'The lowest price if the price is a range.');
        $this->registerArgument('price', 'mixed', 'The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.');
        $this->registerArgument('priceCurrency', 'mixed', 'The currency of the price, or a price component when attached to PriceSpecification and its subtypes.');
        $this->registerArgument('validFrom', 'mixed', 'The date when the item becomes valid.');
        $this->registerArgument('validThrough', 'mixed', 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.');
        $this->registerArgument('valueAddedTaxIncluded', 'mixed', 'Specifies whether the applicable value-added tax (VAT) is included in the price specification or not.');
    }
}
