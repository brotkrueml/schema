<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

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
class JobPostingViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('baseSalary', 'mixed', 'The base salary of the job or of an employee in an EmployeeRole.');
        $this->registerArgument('datePosted', 'mixed', 'Publication date for the job posting.');
        $this->registerArgument('employmentType', 'mixed', 'Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).');
        $this->registerArgument('estimatedSalary', 'mixed', 'An estimated salary for a job posting or occupation, based on a variety of variables including, but not limited to industry, job title, and location. Estimated salaries  are often computed by outside organizations rather than the hiring organization, who may not have committed to the estimated value.');
        $this->registerArgument('experienceRequirements', 'mixed', 'Description of skills and experience needed for the position or Occupation.');
        $this->registerArgument('hiringOrganization', 'mixed', 'Organization offering the job position.');
        $this->registerArgument('incentiveCompensation', 'mixed', 'Description of bonus and commission compensation aspects of the job.');
        $this->registerArgument('industry', 'mixed', 'The industry associated with the job position.');
        $this->registerArgument('jobBenefits', 'mixed', 'Description of benefits associated with the job.');
        $this->registerArgument('jobLocation', 'mixed', 'A (typically single) geographic location associated with the job position.');
        $this->registerArgument('occupationalCategory', 'mixed', 'Category or categories describing the job. Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html. Ideally includes textual label and formal code, with the property repeated for each applicable value.');
        $this->registerArgument('relevantOccupation', 'mixed', 'The Occupation for the JobPosting.');
        $this->registerArgument('responsibilities', 'mixed', 'Responsibilities associated with this role or Occupation.');
        $this->registerArgument('salaryCurrency', 'mixed', 'The currency (coded using ISO 4217 ) used for the main salary information in this job posting or for this employee.');
        $this->registerArgument('skills', 'mixed', 'Skills required to fulfill this role or in this Occupation.');
        $this->registerArgument('specialCommitments', 'mixed', 'Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.');
        $this->registerArgument('title', 'mixed', 'The title of the job.');
        $this->registerArgument('validThrough', 'mixed', 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.');
        $this->registerArgument('workHours', 'mixed', 'The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).');
    }
}
