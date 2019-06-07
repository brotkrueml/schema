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
 * The act of transferring/moving (abstract or concrete) animate or inanimate objects from one place to another.
 *
 * schema.org version 3.6
 */
class TransferAction extends Action
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('fromLocation', 'toLocation');
    }
}
