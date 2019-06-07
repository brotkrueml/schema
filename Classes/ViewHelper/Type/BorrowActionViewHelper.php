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
 * The act of obtaining an object under an agreement to return it at a later date. Reciprocal of LendAction.
 *
 * schema.org version 3.6
 */
class BorrowActionViewHelper extends TransferActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('lender', 'mixed', 'A sub property of participant. The person that lends the object being borrowed.');
    }
}
