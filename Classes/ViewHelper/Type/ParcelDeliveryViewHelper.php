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
 * The delivery of a parcel either via the postal service or a commercial service.
 *
 * schema.org version 3.6
 */
class ParcelDeliveryViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('deliveryAddress', 'mixed', 'Destination address.');
        $this->registerArgument('deliveryStatus', 'mixed', 'New entry added as the package passes through each leg of its journey (from shipment to final delivery).');
        $this->registerArgument('expectedArrivalFrom', 'mixed', 'The earliest date the package may arrive.');
        $this->registerArgument('expectedArrivalUntil', 'mixed', 'The latest date the package may arrive.');
        $this->registerArgument('hasDeliveryMethod', 'mixed', 'Method used for delivery or shipping.');
        $this->registerArgument('itemShipped', 'mixed', 'Item(s) being shipped.');
        $this->registerArgument('originAddress', 'mixed', 'Shipper\'s address.');
        $this->registerArgument('partOfOrder', 'mixed', 'The overall order the items in this delivery were included in.');
        $this->registerArgument('provider', 'mixed', 'The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.');
        $this->registerArgument('trackingNumber', 'mixed', 'Shipper tracking number.');
        $this->registerArgument('trackingUrl', 'mixed', 'Tracking url for the parcel delivery.');
    }
}
