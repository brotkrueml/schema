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
 * A contact point - for example, a Customer Complaints department.
 */
#[Type('ContactPoint')]
#[Manual(Publisher::Google, 'Organization', 'https://developers.google.com/search/docs/appearance/structured-data/organization')]
final class ContactPoint extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
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
        'owner',
        'potentialAction',
        'productSupported',
        'sameAs',
        'subjectOf',
        'telephone',
        'url',
    ];
}
