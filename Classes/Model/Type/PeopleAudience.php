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
 * A set of characteristics belonging to people, e.g. who compose an item's target audience.
 */
#[Type('PeopleAudience')]
final class PeopleAudience extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'audienceType',
        'description',
        'disambiguatingDescription',
        'geographicArea',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'requiredGender',
        'requiredMaxAge',
        'requiredMinAge',
        'sameAs',
        'subjectOf',
        'suggestedGender',
        'suggestedMaxAge',
        'suggestedMinAge',
        'url',
    ];
}
