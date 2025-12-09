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
 * A tool used (but not consumed) when performing instructions for how to achieve a result.
 */
#[Type('HowToTool')]
final class HowToTool extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
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
