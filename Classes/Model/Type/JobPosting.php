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
#[Manual(Publisher::Google, 'Job posting', 'https://developers.google.com/search/docs/appearance/structured-data/job-posting#job-posting-definition')]
final class JobPosting extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'applicationContact',
        'baseSalary',
        'datePosted',
        'description',
        'disambiguatingDescription',
        'eligibilityToWorkRequirement',
        'employerOverview',
        'employmentType',
        'employmentUnit',
        'estimatedSalary',
        'experienceRequirements',
        'hiringOrganization',
        'identifier',
        'image',
        'incentiveCompensation',
        'industry',
        'jobBenefits',
        'jobImmediateStart',
        'jobLocation',
        'jobLocationType',
        'jobStartDate',
        'mainEntityOfPage',
        'name',
        'owner',
        'physicalRequirement',
        'potentialAction',
        'relevantOccupation',
        'responsibilities',
        'salaryCurrency',
        'sameAs',
        'securityClearanceRequirement',
        'sensoryRequirement',
        'skills',
        'specialCommitments',
        'subjectOf',
        'title',
        'totalJobOpenings',
        'url',
        'validThrough',
        'workHours',
    ];
}
