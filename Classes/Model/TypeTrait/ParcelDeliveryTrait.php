<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
trait ParcelDeliveryTrait
{
    protected $deliveryAddress;
    protected $deliveryStatus;
    protected $expectedArrivalFrom;
    protected $expectedArrivalUntil;
    protected $hasDeliveryMethod;
    protected $itemShipped;
    protected $originAddress;
    protected $partOfOrder;
    protected $provider;
    protected $trackingNumber;
    protected $trackingUrl;
}
