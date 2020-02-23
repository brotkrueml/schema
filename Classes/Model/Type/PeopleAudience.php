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
 * A set of characteristics belonging to people, e.g. who compose an item\&#039;s target audience.
 */
final class PeopleAudience extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'audienceType' => null,
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
