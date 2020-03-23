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
 * A set of requirements that a must be fulfilled in order to perform an Action.
 */
final class ActionAccessSpecification extends AbstractType
{
    protected static $propertyNames = [
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
