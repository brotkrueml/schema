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
 * A subclass of OrganizationRole used to describe employee relationships.
 *
 * schema.org version 3.6
 */
class EmployeeRoleViewHelper extends OrganizationRoleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('baseSalary', 'mixed', 'The base salary of the job or of an employee in an EmployeeRole.');
        $this->registerArgument('salaryCurrency', 'mixed', 'The currency (coded using ISO 4217 ) used for the main salary information in this job posting or for this employee.');
    }
}
