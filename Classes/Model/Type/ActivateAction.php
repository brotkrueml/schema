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
 * The act of starting or activating a device or application (e.g. starting a timer or turning on a flashlight).
 *
 * schema.org version 3.6
 */
class ActivateAction extends ControlAction
{
    public function __construct()
    {
        parent::__construct();
    }
}
