<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A listing that describes a job opening in a certain organization.
 *
 * schema.org version 3.6
 */
class JobPosting extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('baseSalary', 'datePosted', 'employmentType', 'estimatedSalary', 'experienceRequirements', 'hiringOrganization', 'incentiveCompensation', 'industry', 'jobBenefits', 'jobLocation', 'occupationalCategory', 'relevantOccupation', 'responsibilities', 'salaryCurrency', 'skills', 'specialCommitments', 'title', 'validThrough', 'workHours');
    }
}
