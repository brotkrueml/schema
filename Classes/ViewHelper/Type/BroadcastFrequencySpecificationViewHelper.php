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
 * The frequency in MHz and the modulation used for a particular BroadcastService.
 *
 * schema.org version 3.6
 */
class BroadcastFrequencySpecificationViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('broadcastFrequencyValue', 'mixed', 'The frequency in MHz for a particular broadcast.');
    }
}
