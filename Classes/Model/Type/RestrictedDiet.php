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
 * A diet restricted to certain foods or preparations for cultural, religious, health or lifestyle reasons.
 *
 * schema.org version 3.6
 */
class RestrictedDiet extends Enumeration
{
    public function __construct()
    {
        parent::__construct();
    }
}
