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
 * The price for the delivery of an offer using a particular delivery method.
 *
 * schema.org version 3.6
 */
class DeliveryChargeSpecification extends PriceSpecification
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('appliesToDeliveryMethod', 'areaServed', 'eligibleRegion', 'ineligibleRegion');
    }
}
