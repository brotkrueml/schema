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
 * A service provided by a government organization, e.g. food stamps, veterans benefits, etc.
 *
 * schema.org version 3.6
 */
class GovernmentServiceViewHelper extends ServiceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('serviceOperator', 'mixed', 'The operating organization, if different from the provider.  This enables the representation of services that are provided by an organization, but operated by another organization like a subcontractor.');
    }
}
