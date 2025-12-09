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
 * A supply consumed when performing the instructions for how to achieve a result.
 */
#[Type('HowToSupply')]
final class HowToSupply extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'estimatedCost',
        'identifier',
        'image',
        'item',
        'mainEntityOfPage',
        'name',
        'nextItem',
        'owner',
        'position',
        'potentialAction',
        'previousItem',
        'requiredQuantity',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
