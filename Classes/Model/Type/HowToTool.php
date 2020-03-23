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
 * A tool used (but not consumed) when performing instructions for how to achieve a result.
 */
final class HowToTool extends AbstractType
{
    protected static $propertyNames = [
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
        'position',
        'potentialAction',
        'previousItem',
        'requiredQuantity',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
