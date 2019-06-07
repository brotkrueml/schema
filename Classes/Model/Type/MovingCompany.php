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
 * A moving company.
 *
 * schema.org version 3.6
 */
class MovingCompany extends HomeAndConstructionBusiness
{
    public function __construct()
    {
        parent::__construct();
    }
}
