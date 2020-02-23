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
 * A single item within a larger data feed.
 */
final class DataFeedItem extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'dateCreated' => null,
        'dateDeleted' => null,
        'dateModified' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'item' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
