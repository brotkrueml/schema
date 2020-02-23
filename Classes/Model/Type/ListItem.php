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
 * An list item, e.g. a step in a checklist or how-to description.
 */
final class ListItem extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'item' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'nextItem' => null,
        'position' => null,
        'potentialAction' => null,
        'previousItem' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
