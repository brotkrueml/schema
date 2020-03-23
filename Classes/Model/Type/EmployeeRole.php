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
 * A subclass of OrganizationRole used to describe employee relationships.
 */
final class EmployeeRole extends AbstractType
{
    protected static $propertyNames = [
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
