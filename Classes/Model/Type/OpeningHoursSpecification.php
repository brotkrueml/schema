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
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 */
final class OpeningHoursSpecification extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'closes',
        'dayOfWeek',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'opens',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'validFrom',
        'validThrough',
    ];
}
