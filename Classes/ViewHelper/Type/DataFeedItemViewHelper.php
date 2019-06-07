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
 * A single item within a larger data feed.
 *
 * schema.org version 3.6
 */
class DataFeedItemViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('dateCreated', 'mixed', 'The date on which the CreativeWork was created or the item was added to a DataFeed.');
        $this->registerArgument('dateDeleted', 'mixed', 'The datetime the item was removed from the DataFeed.');
        $this->registerArgument('dateModified', 'mixed', 'The date on which the CreativeWork was most recently modified or when the item\'s entry was modified within a DataFeed.');
        $this->registerArgument('item', 'mixed', 'An entity represented by an entry in a list or data feed (e.g. an \'artist\' in a list of \'artists\')’.');
    }
}
