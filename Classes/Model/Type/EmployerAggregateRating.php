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
 * An aggregate rating of an Organization related to its role as an employer.
 */
final class EmployerAggregateRating extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'author' => null,
        'bestRating' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'itemReviewed' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'ratingCount' => null,
        'ratingValue' => null,
        'reviewAspect' => null,
        'reviewCount' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
        'worstRating' => null,
    ];
}
