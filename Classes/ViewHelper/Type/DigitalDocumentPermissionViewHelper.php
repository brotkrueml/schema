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
 * A permission for a particular person or group to access a particular file.
 *
 * schema.org version 3.6
 */
class DigitalDocumentPermissionViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('grantee', 'mixed', 'The person, organization, contact point, or audience that has been granted this permission.');
        $this->registerArgument('permissionType', 'mixed', 'The type of permission granted the person, organization, or audience.');
    }
}
