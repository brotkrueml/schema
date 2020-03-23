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
 * An entry point, within some Web-based protocol.
 */
final class EntryPoint extends AbstractType
{
    protected static $propertyNames = [
        'actionApplication',
        'actionPlatform',
        'additionalType',
        'alternateName',
        'contentType',
        'description',
        'disambiguatingDescription',
        'encodingType',
        'httpMethod',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'urlTemplate',
    ];
}
