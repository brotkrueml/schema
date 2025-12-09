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
 * An aggregate rating of an Organization related to its role as an employer.
 */
#[Type('EmployerAggregateRating')]
#[Manual(Publisher::Google, 'Employer aggregate rating', 'https://developers.google.com/search/docs/appearance/structured-data/employer-rating')]
final class EmployerAggregateRating extends AbstractType
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
        'itemReviewed',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'ratingCount',
        'ratingValue',
        'reviewAspect',
        'reviewCount',
        'sameAs',
        'subjectOf',
        'url',
        'worstRating',
    ];
}
