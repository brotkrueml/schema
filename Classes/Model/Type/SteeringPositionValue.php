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
 * A value indicating a steering position.
 * @deprecated This type represents an enumeration, use the specific SteeringPositionValue enum instead.
 */
#[Type('SteeringPositionValue')]
final class SteeringPositionValue extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'equal',
        'greater',
        'greaterOrEqual',
        'identifier',
        'image',
        'lesser',
        'lesserOrEqual',
        'mainEntityOfPage',
        'name',
        'nonEqual',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'valueReference',
    ];
}
