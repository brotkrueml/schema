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
 * A geographical region, typically under the jurisdiction of a particular government.
 *
 * schema.org version 3.6
 */
class AdministrativeAreaViewHelper extends PlaceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
