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
 * Web applications.
 *
 * schema.org version 3.6
 */
class WebApplicationViewHelper extends SoftwareApplicationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('browserRequirements', 'mixed', 'Specifies browser requirements in human-readable text. For example, \'requires HTML5 support\'.');
    }
}
