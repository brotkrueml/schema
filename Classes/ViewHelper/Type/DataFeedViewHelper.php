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
 * A single feed providing structured information about one or more entities or topics.
 *
 * schema.org version 3.6
 */
class DataFeedViewHelper extends DatasetViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('dataFeedElement', 'mixed', 'An item within in a data feed. Data feeds may have many elements.');
    }
}
