<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class BusinessAudience extends Audience
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('numberOfEmployees', 'yearlyRevenue', 'yearsInOperation');
    }
}
