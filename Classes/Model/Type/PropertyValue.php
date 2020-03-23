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
 * A property-value pair, e.g. representing a feature of a product or place. Use the \&#039;name\&#039; property for the name of the property. If there is an additional human-readable version of the value, put that into the \&#039;description\&#039; property.
 */
final class PropertyValue extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'maxValue',
        'minValue',
        'name',
        'potentialAction',
        'propertyID',
        'sameAs',
        'subjectOf',
        'unitCode',
        'unitText',
        'url',
        'value',
        'valueReference',
    ];
}
