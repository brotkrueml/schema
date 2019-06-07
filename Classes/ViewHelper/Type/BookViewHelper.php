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
 * A book.
 *
 * schema.org version 3.6
 */
class BookViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('bookEdition', 'mixed', 'The edition of the book.');
        $this->registerArgument('bookFormat', 'mixed', 'The format of the book.');
        $this->registerArgument('illustrator', 'mixed', 'The illustrator of the book.');
        $this->registerArgument('isbn', 'mixed', 'The ISBN of the book.');
        $this->registerArgument('numberOfPages', 'mixed', 'The number of pages in the book.');
    }
}
