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
 * A doctor\'s office.
 *
 * schema.org version 3.6
 */
class PhysicianViewHelper extends MedicalOrganizationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
