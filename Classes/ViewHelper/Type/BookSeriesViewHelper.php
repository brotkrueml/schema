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
 * A series of books. Included books can be indicated with the hasPart property.
 *
 * schema.org version 3.6
 */
class BookSeriesViewHelper extends CreativeWorkSeriesViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
