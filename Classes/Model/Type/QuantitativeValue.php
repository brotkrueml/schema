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
 * A point value or interval for product characteristics and other purposes.
 */
final class QuantitativeValue extends AbstractType
{
    protected $properties = [
        'additionalProperty' => null,
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'maxValue' => null,
        'minValue' => null,
        'name' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'unitCode' => null,
        'unitText' => null,
        'url' => null,
        'value' => null,
        'valueReference' => null,
    ];
}
