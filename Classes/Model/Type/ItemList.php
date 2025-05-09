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
 * A list of items of any sort - for example, Top 10 Movies About Weathermen, or Top 100 Party Songs. Not to be confused with HTML lists, which are often used only for formatting.
 */
#[Type('ItemList')]
#[Manual(Publisher::Google, 'Carousel', 'https://developers.google.com/search/docs/appearance/structured-data/carousel')]
#[Manual(Publisher::Google, 'Recipe', 'https://developers.google.com/search/docs/appearance/structured-data/recipe#item-list')]
final class ItemList extends AbstractType
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
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
