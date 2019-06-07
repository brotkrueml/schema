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
 * When a single product is associated with multiple offers (for example, the same pair of shoes is offered by different merchants), then AggregateOffer can be used.
 *
 * schema.org version 3.6
 */
class AggregateOffer extends Offer
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('highPrice', 'lowPrice', 'offerCount', 'offers');
    }
}
