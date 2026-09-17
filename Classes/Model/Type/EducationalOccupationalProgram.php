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
 * A program offered by an institution which determines the learning progress to achieve an outcome, usually a credential like a degree or certificate. This would define a discrete set of opportunities (e.g., job, courses) that together constitute a program with a clear start, end, set of requirements, and transition to a new occupational opportunity (e.g., a job), or sometimes a higher educational opportunity (e.g., an advanced degree).
 */
#[Type('EducationalOccupationalProgram')]
final class EducationalOccupationalProgram extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'applicationDeadline',
        'applicationStartDate',
        'dayOfWeek',
        'description',
        'disambiguatingDescription',
        'educationalCredentialAwarded',
        'educationalProgramMode',
        'endDate',
        'financialAidEligible',
        'hasCourse',
        'identifier',
        'image',
        'mainEntityOfPage',
        'maximumEnrollment',
        'name',
        'numberOfCredits',
        'occupationalCredentialAwarded',
        'offers',
        'owner',
        'potentialAction',
        'programPrerequisites',
        'programType',
        'provider',
        'salaryUponCompletion',
        'sameAs',
        'startDate',
        'subjectOf',
        'termDuration',
        'termsPerYear',
        'timeOfDay',
        'timeToComplete',
        'trainingSalary',
        'typicalCreditsPerTerm',
        'url',
    ];
}
