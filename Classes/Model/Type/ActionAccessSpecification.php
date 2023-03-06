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
 * A set of requirements that must be fulfilled in order to perform an Action.
 */
#[Type('ActionAccessSpecification')]
final class ActionAccessSpecification extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'availabilityEnds',
        'availabilityStarts',
        'category',
        'description',
        'disambiguatingDescription',
        'eligibleRegion',
        'expectsAcceptanceOf',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'requiresSubscription',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
