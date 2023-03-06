<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

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
 */
#[Type('DeliveryMethod')]
final class DeliveryMethod extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
