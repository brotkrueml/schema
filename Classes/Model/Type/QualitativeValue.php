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
 * A predefined value for a product characteristic, e.g. the power cord plug type \&#039;US\&#039; or the garment sizes \&#039;S\&#039;, \&#039;M\&#039;, \&#039;L\&#039;, and \&#039;XL\&#039;.
 */
final class QualitativeValue extends AbstractType
{
    protected static $propertyNames = [
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
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'valueReference',
    ];
}
