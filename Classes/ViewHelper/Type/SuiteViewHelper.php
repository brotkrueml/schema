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
 * A suite in a hotel or other public accommodation, denotes a class of luxury accommodations, the key feature of which is multiple rooms (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Suite_(hotel)).
 *
 * schema.org version 3.6
 */
class SuiteViewHelper extends AccommodationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('bed', 'mixed', 'The type of bed or beds included in the accommodation. For the single case of just one bed of a certain type, you use bed directly with a text.');
        $this->registerArgument('occupancy', 'mixed', 'The allowed total occupancy for the accommodation in persons (including infants etc). For individual accommodations, this is not necessarily the legal maximum but defines the permitted usage as per the contractual agreement (e.g. a double room used by a single person).');
    }
}
