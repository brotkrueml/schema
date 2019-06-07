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
 * A unique instance of a BroadcastService on a CableOrSatelliteService lineup.
 *
 * schema.org version 3.6
 */
class BroadcastChannelViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('broadcastChannelId', 'mixed', 'The unique address by which the BroadcastService can be identified in a provider lineup. In US, this is typically a number.');
        $this->registerArgument('broadcastFrequency', 'mixed', 'The frequency used for over-the-air broadcasts. Numeric values or simple ranges e.g. 87-99. In addition a shortcut idiom is supported for frequences of AM and FM radio channels, e.g. "87 FM".');
        $this->registerArgument('broadcastServiceTier', 'mixed', 'The type of service required to have access to the channel (e.g. Standard or Premium).');
        $this->registerArgument('genre', 'mixed', 'Genre of the creative work, broadcast channel or group.');
        $this->registerArgument('inBroadcastLineup', 'mixed', 'The CableOrSatelliteService offering the channel.');
        $this->registerArgument('providesBroadcastService', 'mixed', 'The BroadcastService offered on this channel.');
    }
}
