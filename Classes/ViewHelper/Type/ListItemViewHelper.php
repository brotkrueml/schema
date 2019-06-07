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
 * An list item, e.g. a step in a checklist or how-to description.
 *
 * schema.org version 3.6
 */
class ListItemViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('item', 'mixed', 'An entity represented by an entry in a list or data feed (e.g. an \'artist\' in a list of \'artists\')’.');
        $this->registerArgument('nextItem', 'mixed', 'A link to the ListItem that follows the current one.');
        $this->registerArgument('position', 'mixed', 'The position of an item in a series or sequence of items.');
        $this->registerArgument('previousItem', 'mixed', 'A link to the ListItem that preceeds the current one.');
    }
}
