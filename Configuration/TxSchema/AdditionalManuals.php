<?php

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * @internal
 */
return [
    'Article' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/article',
        ],
    ],
    'BlogPosting' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/article',
        ],
    ],
    'Book' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/book',
        ],
    ],
    'BreadcrumbList' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/breadcrumb',
        ],
    ],
    'ClaimReview' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/factcheck',
        ],
    ],
    'Course' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/course',
        ],
    ],
    'CreativeWork' => [
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/essay.html',
        ],
    ],
    'Dataset' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/dataset',
        ],
    ],
    'EducationalOccupationalProgram' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/job-training',
        ],
    ],
    'EmployerAggregateRating' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/employer-rating',
        ],
    ],
    'Event' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/event',
        ],
    ],
    'FAQPage' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/faqpage',
        ],
    ],
    'HowTo' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/how-to',
        ],
    ],
    'ImageObject' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/image-license-metadata',
        ],
    ],
    'JobPosting' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/job-posting',
        ],
    ],
    'MobileApplication' => [
        'like' => 'SoftwareApplication',
    ],
    'MonetaryAmountDistribution' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/estimated-salary',
        ],
    ],
    'Movie' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/movie',
        ],
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/movie-description.html',
        ],
    ],
    'NewsArticle' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/article',
        ],
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/paywalled-content',
        ],
    ],
    'Organization' => [
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/address-organization.html',
        ],
    ],
    'Product' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/product',
        ],
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/goods-prices.html',
        ],
    ],
    'QAPage' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/qapage',
        ],
    ],
    'Question' => [
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/questions.html',
        ],
    ],
    'Recipe' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/recipe',
        ],
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/recipe.html',
        ],
    ],
    'Review' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/review-snippet',
        ],
    ],
    'SoftwareApplication' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/software-app',
        ],
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/webmaster/supported-schemas/software.html',
        ],
    ],
    'VideoGame' => [
        'like' => 'SoftwareApplication',
    ],
    'VideoObject' => [
        [
            'provider' => 'google',
            'link' => 'https://developers.google.com/search/docs/data-types/video',
        ],
        [
            'provider' => 'yandex',
            'link' => 'https://yandex.com/support/video/partners/schema-org.html',
        ],
    ],
    'WebApplication' => [
        'like' => 'SoftwareApplication',
    ],
];
