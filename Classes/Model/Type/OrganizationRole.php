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
 * A subclass of Role used to describe roles within organizations.
 */
#[Type('OrganizationRole')]
final class OrganizationRole extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'endDate',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'numberedPosition',
        'potentialAction',
        'roleName',
        'sameAs',
        'startDate',
        'subjectOf',
        'url',
    ];
}
