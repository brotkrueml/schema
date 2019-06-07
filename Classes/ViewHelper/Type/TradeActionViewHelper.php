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
 * The act of participating in an exchange of goods and services for monetary compensation. An agent trades an object, product or service with a participant in exchange for a one time or periodic payment.
 *
 * schema.org version 3.6
 */
class TradeActionViewHelper extends ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('price', 'mixed', 'The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.');
        $this->registerArgument('priceCurrency', 'mixed', 'The currency of the price, or a price component when attached to PriceSpecification and its subtypes.');
        $this->registerArgument('priceSpecification', 'mixed', 'One or more detailed price specifications, indicating the unit price and delivery or payment charges.');
    }
}
