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
 * The average rating based on multiple ratings or reviews.
 */
#[Type('AggregateRating')]
#[Manual(Publisher::Google, 'Review snippet', 'https://developers.google.com/search/docs/appearance/structured-data/review-snippet#aggregate-rating')]
#[Manual(Publisher::Google, 'Product snippet: Shopping aggregator page', 'https://developers.google.com/search/docs/appearance/structured-data/product-snippet#shopping-aggregator-page-example')]
final class AggregateRating extends AbstractType
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
