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
 * A permission for a particular person or group to access a particular file.
 */
final class DigitalDocumentPermission extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'grantee',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'permissionType',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
