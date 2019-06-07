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
 * The delivery of a parcel either via the postal service or a commercial service.
 *
 * schema.org version 3.6
 */
class ParcelDelivery extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('deliveryAddress', 'deliveryStatus', 'expectedArrivalFrom', 'expectedArrivalUntil', 'hasDeliveryMethod', 'itemShipped', 'originAddress', 'partOfOrder', 'provider', 'trackingNumber', 'trackingUrl');
    }
}
