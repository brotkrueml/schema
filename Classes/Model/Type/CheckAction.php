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
 * An agent inspects, determines, investigates, inquires, or examines an object\'s accuracy, quality, condition, or state.
 *
 * schema.org version 3.6
 */
class CheckAction extends FindAction
{
    public function __construct()
    {
        parent::__construct();
    }
}
