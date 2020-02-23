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
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'audienceType' => null,
        'childMaxAge' => null,
        'childMinAge' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'geographicArea' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'requiredGender' => null,
        'requiredMaxAge' => null,
        'requiredMinAge' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'suggestedGender' => null,
        'suggestedMaxAge' => null,
        'suggestedMinAge' => null,
        'url' => null,
    ];
}
