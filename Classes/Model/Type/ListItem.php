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
 * An list item, e.g. a step in a checklist or how-to description.
 */
#[Type('ListItem')]
#[Manual(Publisher::Google, 'Breadcrumb', 'https://developers.google.com/search/docs/appearance/structured-data/breadcrumb#list-item')]
final class ListItem extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'item',
        'mainEntityOfPage',
        'name',
        'nextItem',
        'owner',
        'position',
        'potentialAction',
        'previousItem',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
