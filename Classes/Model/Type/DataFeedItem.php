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
 * A single item within a larger data feed.
 */
#[Type('DataFeedItem')]
final class DataFeedItem extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'dateCreated',
        'dateDeleted',
        'dateModified',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'item',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
