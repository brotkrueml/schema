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
 * A self-storage facility.
 *
 * schema.org version 3.6
 */
class SelfStorage extends LocalBusiness
{
    public function __construct()
    {
        parent::__construct();
    }
}
