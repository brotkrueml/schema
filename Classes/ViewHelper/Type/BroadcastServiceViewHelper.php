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
 * A delivery service through which content is provided via broadcast over the air or online.
 *
 * schema.org version 3.6
 */
class BroadcastServiceViewHelper extends ServiceViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('broadcastAffiliateOf', 'mixed', 'The media network(s) whose content is broadcast on this station.');
        $this->registerArgument('broadcastDisplayName', 'mixed', 'The name displayed in the channel guide. For many US affiliates, it is the network name.');
        $this->registerArgument('broadcastFrequency', 'mixed', 'The frequency used for over-the-air broadcasts. Numeric values or simple ranges e.g. 87-99. In addition a shortcut idiom is supported for frequences of AM and FM radio channels, e.g. "87 FM".');
        $this->registerArgument('broadcastTimezone', 'mixed', 'The timezone in ISO 8601 format for which the service bases its broadcasts');
        $this->registerArgument('broadcaster', 'mixed', 'The organization owning or operating the broadcast service.');
        $this->registerArgument('hasBroadcastChannel', 'mixed', 'A broadcast channel of a broadcast service.');
        $this->registerArgument('parentService', 'mixed', 'A broadcast service to which the broadcast service may belong to such as regional variations of a national channel.');
        $this->registerArgument('videoFormat', 'mixed', 'The type of screening or video broadcast used (e.g. IMAX, 3D, SD, HD, etc.).');
    }
}
