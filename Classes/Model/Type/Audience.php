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
 * Intended audience for an item, i.e. the group for whom the item was created.
 */
final class Audience extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'audienceType',
        'description',
        'disambiguatingDescription',
        'geographicArea',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
