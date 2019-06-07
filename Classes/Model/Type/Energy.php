<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Properties that take Energy as values are of the form \'&lt;Number&gt; &lt;Energy unit of measure&gt;\'.
 *
 * schema.org version 3.6
 */
class Energy extends Quantity
{
    public function __construct()
    {
        parent::__construct();
    }
}
