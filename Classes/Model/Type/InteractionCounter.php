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
 * A summary of how users have interacted with this CreativeWork. In most cases, authors will use a subtype to specify the specific type of interaction.
 */
#[Type('InteractionCounter')]
final class InteractionCounter extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'endTime',
        'identifier',
        'image',
        'interactionService',
        'interactionType',
        'location',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'startTime',
        'subjectOf',
        'url',
        'userInteractionCount',
    ];
}
