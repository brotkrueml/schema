<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * The delivery of a parcel either via the postal service or a commercial service.
 */
final class ParcelDelivery extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'deliveryAddress' => null,
        'deliveryStatus' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'expectedArrivalFrom' => null,
        'expectedArrivalUntil' => null,
        'hasDeliveryMethod' => null,
        'identifier' => null,
        'image' => null,
        'itemShipped' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'originAddress' => null,
        'partOfOrder' => null,
        'potentialAction' => null,
        'provider' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'trackingNumber' => null,
        'trackingUrl' => null,
        'url' => null,
    ];
}
