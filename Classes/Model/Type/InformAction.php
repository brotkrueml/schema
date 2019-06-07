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
 * The act of notifying someone of information pertinent to them, with no expectation of a response.
 *
 * schema.org version 3.6
 */
class InformAction extends CommunicateAction
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('event');
    }
}
