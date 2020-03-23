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
 * A listing that describes a job opening in a certain organization.
 */
final class JobPosting extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'baseSalary',
        'datePosted',
        'description',
        'disambiguatingDescription',
        'employmentType',
        'estimatedSalary',
        'experienceRequirements',
        'hiringOrganization',
        'identifier',
        'image',
        'incentiveCompensation',
        'industry',
        'jobBenefits',
        'jobLocation',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'relevantOccupation',
        'responsibilities',
        'salaryCurrency',
        'sameAs',
        'skills',
        'specialCommitments',
        'subjectOf',
        'title',
        'url',
        'validThrough',
        'workHours',
    ];
}
