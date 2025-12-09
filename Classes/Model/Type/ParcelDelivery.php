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
 * The delivery of a parcel either via the postal service or a commercial service.
 */
#[Type('ParcelDelivery')]
final class ParcelDelivery extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'deliveryAddress',
        'deliveryStatus',
        'description',
        'disambiguatingDescription',
        'expectedArrivalFrom',
        'expectedArrivalUntil',
        'hasDeliveryMethod',
        'identifier',
        'image',
        'itemShipped',
        'mainEntityOfPage',
        'name',
        'originAddress',
        'owner',
        'partOfOrder',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'trackingNumber',
        'trackingUrl',
        'url',
    ];
}
