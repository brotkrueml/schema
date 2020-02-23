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
    protected $properties = [
        'additionalProperty' => null,
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'equal' => null,
        'greater' => null,
        'greaterOrEqual' => null,
        'identifier' => null,
        'image' => null,
        'lesser' => null,
        'lesserOrEqual' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'nonEqual' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
        'valueReference' => null,
    ];
}
