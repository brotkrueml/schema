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
 * A Category Code.
 */
#[Type('CategoryCode')]
#[Manual(Publisher::Google, 'Merchant listing: Product information', 'https://developers.google.com/search/docs/appearance/structured-data/merchant-listing#product-properties')]
final class CategoryCode extends AbstractType
{
    protected static array $propertyNames = [
        'about',
        'additionalType',
        'alternateName',
        'codeValue',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'inCodeSet',
        'inDefinedTermSet',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'termCode',
        'url',
    ];
}
