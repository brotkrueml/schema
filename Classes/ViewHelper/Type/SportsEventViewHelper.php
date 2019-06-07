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
 * Event type: Sports event.
 *
 * schema.org version 3.6
 */
class SportsEventViewHelper extends EventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('awayTeam', 'mixed', 'The away team in a sports event.');
        $this->registerArgument('competitor', 'mixed', 'A competitor in a sports event.');
        $this->registerArgument('homeTeam', 'mixed', 'The home team in a sports event.');
    }
}
