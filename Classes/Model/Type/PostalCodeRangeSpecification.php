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
 * Indicates a range of postal codes, usually defined as the set of valid codes between postalCodeBegin and postalCodeEnd, inclusively.
 */
#[Type('PostalCodeRangeSpecification')]
final class PostalCodeRangeSpecification extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'postalCodeBegin',
        'postalCodeEnd',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
