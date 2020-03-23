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
 * A brand is a name used by an organization or business person for labeling a product, product group, or similar.
 */
final class Brand extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'aggregateRating',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'logo',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'review',
        'sameAs',
        'slogan',
        'subjectOf',
        'url',
    ];
}
