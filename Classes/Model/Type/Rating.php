<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * A rating is an evaluation on a numeric scale, such as 1 to 5 stars.
 */
#[Type('Rating')]
#[Manual(Publisher::Google, 'Fact check: Rating', 'https://developers.google.com/search/docs/appearance/structured-data/factcheck#rating')]
final class Rating extends AbstractType
{
    protected static array $propertyNames = [
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
