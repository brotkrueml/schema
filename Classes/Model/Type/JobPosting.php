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
 * A listing that describes a job opening in a certain organization.
 */
#[Type('JobPosting')]
#[Manual(Publisher::Google, 'https://developers.google.com/search/docs/data-types/job-posting')]
final class JobPosting extends AbstractType
{
    protected static array $propertyNames = [
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
