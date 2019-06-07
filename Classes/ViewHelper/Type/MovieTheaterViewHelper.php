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
 * A movie theater.
 *
 * schema.org version 3.6
 */
class MovieTheaterViewHelper extends CivicStructureViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('screenCount', 'mixed', 'The number of screens in the movie theater.');
    }
}
