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
 * An OfferCatalog is an ItemList that contains related Offers and/or further OfferCatalogs that are offeredBy the same provider.
 */
#[Type('OfferCatalog')]
#[Manual(Publisher::Yandex, 'Catalogs', 'https://yandex.com/support/webmaster/en/supported-schemas/catalogs')]
final class OfferCatalog extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'itemListElement',
        'itemListOrder',
        'mainEntityOfPage',
        'name',
        'numberOfItems',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
