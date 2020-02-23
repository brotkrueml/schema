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
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'availabilityEnds' => null,
        'availabilityStarts' => null,
        'category' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'eligibleRegion' => null,
        'expectsAcceptanceOf' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'requiresSubscription' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
