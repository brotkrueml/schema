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
 * A service provided by a government organization, e.g. food stamps, veterans benefits, etc.
 *
 * schema.org version 3.6
 */
class GovernmentService extends Service
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('serviceOperator');
    }
}
