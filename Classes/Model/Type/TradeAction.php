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
 * The act of participating in an exchange of goods and services for monetary compensation. An agent trades an object, product or service with a participant in exchange for a one time or periodic payment.
 *
 * schema.org version 3.6
 */
class TradeAction extends Action
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('price', 'priceCurrency', 'priceSpecification');
    }
}
