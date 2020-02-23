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
 * Specifies a location feature by providing a structured value representing a feature of an accommodation as a property-value pair of varying degrees of formality.
 */
final class LocationFeatureSpecification extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'hoursAvailable' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'maxValue' => null,
        'minValue' => null,
        'name' => null,
        'potentialAction' => null,
        'propertyID' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'unitCode' => null,
        'unitText' => null,
        'url' => null,
        'validFrom' => null,
        'validThrough' => null,
        'value' => null,
        'valueReference' => null,
    ];
}
