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
 * A PerformanceRole is a Role that some entity places with regard to a theatrical performance, e.g. in a Movie, TVSeries etc.
 */
final class PerformanceRole extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'characterName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'endDate' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'roleName' => null,
        'sameAs' => null,
        'startDate' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
