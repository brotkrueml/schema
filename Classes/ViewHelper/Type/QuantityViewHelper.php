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
 * Quantities such as distance, time, mass, weight, etc. Particular instances of say Mass are entities like \'3 Kg\' or \'4 milligrams\'.
 *
 * schema.org version 3.6
 */
class QuantityViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
