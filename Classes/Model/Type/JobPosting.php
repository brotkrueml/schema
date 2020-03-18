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
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'baseSalary' => null,
        'datePosted' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'employmentType' => null,
        'estimatedSalary' => null,
        'experienceRequirements' => null,
        'hiringOrganization' => null,
        'identifier' => null,
        'image' => null,
        'incentiveCompensation' => null,
        'industry' => null,
        'jobBenefits' => null,
        'jobLocation' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'relevantOccupation' => null,
        'responsibilities' => null,
        'salaryCurrency' => null,
        'sameAs' => null,
        'skills' => null,
        'specialCommitments' => null,
        'subjectOf' => null,
        'title' => null,
        'url' => null,
        'validThrough' => null,
        'workHours' => null,
    ];
}
