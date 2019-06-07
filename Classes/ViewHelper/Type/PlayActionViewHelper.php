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
 * The act of playing/exercising/training/performing for enjoyment, leisure, recreation, Competition or exercise.
 *
 * schema.org version 3.6
 */
class PlayActionViewHelper extends ActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('audience', 'mixed', 'An intended audience, i.e. a group for whom something was created.');
        $this->registerArgument('event', 'mixed', 'Upcoming or past event associated with this place, organization, or action.');
    }
}
