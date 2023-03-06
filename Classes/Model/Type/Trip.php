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
 * A trip or journey. An itinerary of visits to one or more places.
 */
#[Type('Trip')]
final class Trip extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'arrivalTime',
        'departureTime',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'offers',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
