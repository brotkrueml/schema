<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * ServicePeriod represents a duration with some constraints about cutoff time and business days. This is used e.g. in shipping for handling times or transit time.
 */
#[Type('ServicePeriod')]
#[Manual(Publisher::Google, 'Merchant shipping policy', 'https://developers.google.com/search/docs/appearance/structured-data/shipping-policy#shipping-service-handling-time-properties')]
final class ServicePeriod extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'businessDays',
        'cutoffTime',
        'description',
        'disambiguatingDescription',
        'duration',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
