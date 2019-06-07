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
 * A medical organization (physical or not), such as hospital, institution or clinic.
 *
 * schema.org version 3.6
 */
class MedicalOrganizationViewHelper extends OrganizationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
