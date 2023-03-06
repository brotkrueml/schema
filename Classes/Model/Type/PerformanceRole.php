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
 * A PerformanceRole is a Role that some entity places with regard to a theatrical performance, e.g. in a Movie, TVSeries etc.
 */
#[Type('PerformanceRole')]
final class PerformanceRole extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'characterName',
        'description',
        'disambiguatingDescription',
        'endDate',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'roleName',
        'sameAs',
        'startDate',
        'subjectOf',
        'url',
    ];
}
