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
 * A subclass of OrganizationRole used to describe employee relationships.
 */
#[Type('EmployeeRole')]
final class EmployeeRole extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'baseSalary',
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
        'salaryCurrency',
        'sameAs',
        'startDate',
        'subjectOf',
        'url',
    ];
}
