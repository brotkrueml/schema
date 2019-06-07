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
 * A subclass of Role used to describe roles within organizations.
 *
 * schema.org version 3.6
 */
class OrganizationRoleViewHelper extends RoleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('numberedPosition', 'mixed', 'A number associated with a role in an organization, for example, the number on an athlete\'s jersey.');
    }
}
