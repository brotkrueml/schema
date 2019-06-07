<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * The act of providing an object under an agreement that it will be returned at a later date. Reciprocal of BorrowAction.
 *
 * schema.org version 3.6
 */
class LendActionViewHelper extends TransferActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('borrower', 'mixed', 'A sub property of participant. The person that borrows the object being lent.');
    }
}
