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
 * The act of traveling from an fromLocation to a destination by a specified mode of transport, optionally with participants.
 *
 * schema.org version 3.6
 */
class TravelActionViewHelper extends MoveActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('distance', 'mixed', 'The distance travelled, e.g. exercising or travelling.');
    }
}
