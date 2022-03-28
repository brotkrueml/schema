<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * An EndorsementRating is a rating that expresses some level of endorsement, for example inclusion in a "critic's pick" blog, a
 * endorsement rating is particularly useful in the absence of numeric scales as it helps consumers understand that the rating is broadly positive.
 */
final class EndorsementRating extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'author',
        'bestRating',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'ratingValue',
        'reviewAspect',
        'sameAs',
        'subjectOf',
        'url',
        'worstRating',
    ];
}
