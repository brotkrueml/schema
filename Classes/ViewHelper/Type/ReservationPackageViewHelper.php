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
 * A group of multiple reservations with common values for all sub-reservations.
 *
 * schema.org version 3.6
 */
class ReservationPackageViewHelper extends ReservationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('subReservation', 'mixed', 'The individual reservations included in the package. Typically a repeated property.');
    }
}
