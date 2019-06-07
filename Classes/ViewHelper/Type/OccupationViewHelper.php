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
 * A profession, may involve prolonged training and/or a formal qualification.
 *
 * schema.org version 3.6
 */
class OccupationViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('estimatedSalary', 'mixed', 'An estimated salary for a job posting or occupation, based on a variety of variables including, but not limited to industry, job title, and location. Estimated salaries  are often computed by outside organizations rather than the hiring organization, who may not have committed to the estimated value.');
        $this->registerArgument('experienceRequirements', 'mixed', 'Description of skills and experience needed for the position or Occupation.');
        $this->registerArgument('occupationLocation', 'mixed', 'The region/country for which this occupational description is appropriate. Note that educational requirements and qualifications can vary between jurisdictions.');
        $this->registerArgument('occupationalCategory', 'mixed', 'Category or categories describing the job. Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html. Ideally includes textual label and formal code, with the property repeated for each applicable value.');
        $this->registerArgument('responsibilities', 'mixed', 'Responsibilities associated with this role or Occupation.');
        $this->registerArgument('skills', 'mixed', 'Skills required to fulfill this role or in this Occupation.');
    }
}
