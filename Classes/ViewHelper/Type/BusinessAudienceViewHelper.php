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
 * A set of characteristics belonging to businesses, e.g. who compose an item\'s target audience.
 *
 * schema.org version 3.6
 */
class BusinessAudienceViewHelper extends AudienceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('numberOfEmployees', 'mixed', 'The number of employees in an organization e.g. business.');
        $this->registerArgument('yearlyRevenue', 'mixed', 'The size of the business in annual revenue.');
        $this->registerArgument('yearsInOperation', 'mixed', 'The age of the business.');
    }
}
