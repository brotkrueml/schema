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
 * When a single product is associated with multiple offers (for example, the same pair of shoes is offered by different merchants), then AggregateOffer can be used.
 *
 * schema.org version 3.6
 */
class AggregateOfferViewHelper extends OfferViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('highPrice', 'mixed', 'The highest price of all offers available.');
        $this->registerArgument('lowPrice', 'mixed', 'The lowest price of all offers available.');
        $this->registerArgument('offerCount', 'mixed', 'The number of offers for the product.');
        $this->registerArgument('offers', 'mixed', 'An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.');
    }
}
