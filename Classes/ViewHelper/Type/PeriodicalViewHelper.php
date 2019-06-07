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
 * A publication in any medium issued in successive parts bearing numerical or chronological designations and intended, such as a magazine, scholarly journal, or newspaper to continue indefinitely.
 *
 * schema.org version 3.6
 */
class PeriodicalViewHelper extends CreativeWorkSeriesViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
