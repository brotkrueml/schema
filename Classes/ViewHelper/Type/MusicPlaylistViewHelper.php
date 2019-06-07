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
 * A collection of music tracks in playlist form.
 *
 * schema.org version 3.6
 */
class MusicPlaylistViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('numTracks', 'mixed', 'The number of tracks in this album or playlist.');
        $this->registerArgument('track', 'mixed', 'A music recording (track)&#x2014;usually a single song. If an ItemList is given, the list should contain items of type MusicRecording.');
    }
}
