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
 * An event involving the delivery of an item.
 *
 * schema.org version 3.6
 */
class DeliveryEventViewHelper extends EventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('accessCode', 'mixed', 'Password, PIN, or access code needed for delivery (e.g. from a locker).');
        $this->registerArgument('availableFrom', 'mixed', 'When the item is available for pickup from the store, locker, etc.');
        $this->registerArgument('availableThrough', 'mixed', 'After this date, the item will no longer be available for pickup.');
        $this->registerArgument('hasDeliveryMethod', 'mixed', 'Method used for delivery or shipping.');
    }
}
