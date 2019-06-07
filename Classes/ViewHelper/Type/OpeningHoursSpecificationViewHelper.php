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
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 *
 * schema.org version 3.6
 */
class OpeningHoursSpecificationViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('closes', 'mixed', 'The closing hour of the place or service on the given day(s) of the week.');
        $this->registerArgument('dayOfWeek', 'mixed', 'The day of the week for which these opening hours are valid.');
        $this->registerArgument('opens', 'mixed', 'The opening hour of the place or service on the given day(s) of the week.');
        $this->registerArgument('validFrom', 'mixed', 'The date when the item becomes valid.');
        $this->registerArgument('validThrough', 'mixed', 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.');
    }
}
