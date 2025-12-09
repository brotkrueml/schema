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
 * Specifies a location feature by providing a structured value representing a feature of an accommodation as a property-value pair of varying degrees of formality.
 */
#[Type('LocationFeatureSpecification')]
final class LocationFeatureSpecification extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'hoursAvailable',
        'identifier',
        'image',
        'mainEntityOfPage',
        'maxValue',
        'minValue',
        'name',
        'owner',
        'potentialAction',
        'propertyID',
        'sameAs',
        'subjectOf',
        'unitCode',
        'unitText',
        'url',
        'validFrom',
        'validThrough',
        'value',
        'valueReference',
    ];
}
