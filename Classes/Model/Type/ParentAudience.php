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
 * A set of characteristics describing parents, who can be interested in viewing some content.
 */
final class ParentAudience extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'audienceType',
        'childMaxAge',
        'childMinAge',
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
