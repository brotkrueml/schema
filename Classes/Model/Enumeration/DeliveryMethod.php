<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * A delivery method is a standardized procedure for transferring the product or service to the destination of fulfillment chosen by the customer. Delivery methods are characterized by the means of transportation used, and by the organization or group that is the contracting party for the sending organization or person.
 *
 * Commonly used values:
 * http://purl.org/goodrelations/v1#DeliveryModeDirectDownload
 * http://purl.org/goodrelations/v1#DeliveryModeFreight
 * http://purl.org/goodrelations/v1#DeliveryModeMail
 * http://purl.org/goodrelations/v1#DeliveryModeOwnFleet
 * http://purl.org/goodrelations/v1#DeliveryModePickUp
 * http://purl.org/goodrelations/v1#DHL
 * http://purl.org/goodrelations/v1#FederalExpress
 * http://purl.org/goodrelations/v1#UPS
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum DeliveryMethod implements EnumerationInterface
{
    /**
     * A DeliveryMethod in which an item is made available via locker.
     */
    case LockerDelivery;

    /**
     * A DeliveryMethod in which an item is collected on site, e.g. in a store or at a box office.
     */
    case OnSitePickup;

    /**
     * A private parcel service as the delivery mode available for a certain offer.
     *
     * Commonly used values:
     * http://purl.org/goodrelations/v1#DHL
     * http://purl.org/goodrelations/v1#FederalExpress
     * http://purl.org/goodrelations/v1#UPS
     */
    case ParcelService;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
