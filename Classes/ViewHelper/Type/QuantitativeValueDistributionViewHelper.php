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
 * A statistical distribution of values.
 *
 * schema.org version 3.6
 */
class QuantitativeValueDistributionViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('duration', 'mixed', 'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.');
        $this->registerArgument('median', 'mixed', 'The median value.');
        $this->registerArgument('percentile10', 'mixed', 'The 10th percentile value.');
        $this->registerArgument('percentile25', 'mixed', 'The 25th percentile value.');
        $this->registerArgument('percentile75', 'mixed', 'The 75th percentile value.');
        $this->registerArgument('percentile90', 'mixed', 'The 90th percentile value.');
    }
}
