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
 * The act of giving money in return for temporary use, but not ownership, of an object such as a vehicle or property. For example, an agent rents a property from a landlord in exchange for a periodic payment.
 *
 * schema.org version 3.6
 */
class RentActionViewHelper extends TradeActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('landlord', 'mixed', 'A sub property of participant. The owner of the real estate property.');
        $this->registerArgument('realEstateAgent', 'mixed', 'A sub property of participant. The real estate agent involved in the action.');
    }
}
