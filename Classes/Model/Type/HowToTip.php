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
 * An explanation in the instructions for how to achieve a result. It provides supplementary information about a technique, supply, author\'s preference, etc. It can explain what could be done, or what should not be done, but doesn\'t specify what should be done (see HowToDirection).
 *
 * schema.org version 3.6
 */
class HowToTip extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('item', 'nextItem', 'previousItem');
    }
}
