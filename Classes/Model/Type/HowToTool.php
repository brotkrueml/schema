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
 * A tool used (but not consumed) when performing instructions for how to achieve a result.
 *
 * schema.org version 3.6
 */
class HowToTool extends HowToItem
{
    public function __construct()
    {
        parent::__construct();
    }
}
