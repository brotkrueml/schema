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
 * A point value or interval for product characteristics and other purposes.
 */
#[Type('QuantitativeValue')]
final class QuantitativeValue extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
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
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'unitCode',
        'unitText',
        'url',
        'value',
        'valueReference',
    ];
}
