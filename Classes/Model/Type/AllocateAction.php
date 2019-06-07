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
 * The act of organizing tasks/objects/events by associating resources to it.
 *
 * schema.org version 3.6
 */
class AllocateAction extends OrganizeAction
{
    public function __construct()
    {
        parent::__construct();
    }
}
