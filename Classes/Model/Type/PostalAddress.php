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
 * The mailing address.
 */
#[Type('PostalAddress')]
final class PostalAddress extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'addressCountry',
        'addressLocality',
        'addressRegion',
        'alternateName',
        'areaServed',
        'availableLanguage',
        'contactOption',
        'contactType',
        'description',
        'disambiguatingDescription',
        'email',
        'faxNumber',
        'hoursAvailable',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'postOfficeBoxNumber',
        'postalCode',
        'potentialAction',
        'productSupported',
        'sameAs',
        'streetAddress',
        'subjectOf',
        'telephone',
        'url',
    ];
}
