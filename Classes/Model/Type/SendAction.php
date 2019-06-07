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
 * The act of physically/electronically dispatching an object for transfer from an origin to a destination.Related actions:
 *
 * schema.org version 3.6
 */
class SendAction extends TransferAction
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('deliveryMethod', 'recipient');
    }
}
