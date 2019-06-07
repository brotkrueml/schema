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
 * Properties that take Mass as values are of the form \'&lt;Number&gt; &lt;Mass unit of measure&gt;\'. E.g., \'7 kg\'.
 *
 * schema.org version 3.6
 */
class MassViewHelper extends QuantityViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
