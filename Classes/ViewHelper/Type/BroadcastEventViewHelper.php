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
 * An over the air or online broadcast event.
 *
 * schema.org version 3.6
 */
class BroadcastEventViewHelper extends PublicationEventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('broadcastOfEvent', 'mixed', 'The event being broadcast such as a sporting event or awards ceremony.');
        $this->registerArgument('isLiveBroadcast', 'mixed', 'True is the broadcast is of a live event.');
        $this->registerArgument('videoFormat', 'mixed', 'The type of screening or video broadcast used (e.g. IMAX, 3D, SD, HD, etc.).');
    }
}
