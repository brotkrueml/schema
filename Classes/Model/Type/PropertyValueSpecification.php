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
 * A Property value specification.
 */
#[Type('PropertyValueSpecification')]
final class PropertyValueSpecification extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'defaultValue',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'maxValue',
        'minValue',
        'multipleValues',
        'name',
        'owner',
        'potentialAction',
        'readonlyValue',
        'sameAs',
        'stepValue',
        'subjectOf',
        'url',
        'valueMaxLength',
        'valueMinLength',
        'valueName',
        'valuePattern',
        'valueRequired',
    ];
}
