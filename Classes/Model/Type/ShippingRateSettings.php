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
 * A ShippingRateSettings represents re-usable pieces of shipping information. It is designed for publication on an URL that may be referenced via the shippingSettingsLink property of an OfferShippingDetails. Several occurrences can be published, distinguished and matched (i.e. identified/referenced) by their different values for shippingLabel.
 */
#[Type('ShippingRateSettings')]
final class ShippingRateSettings extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'doesNotShip',
        'freeShippingThreshold',
        'identifier',
        'image',
        'isUnlabelledFallback',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'shippingDestination',
        'shippingRate',
        'subjectOf',
        'url',
    ];
}
