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
 * A music recording (track), usually a single song.
 *
 * schema.org version 3.6
 */
class MusicRecordingViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('byArtist', 'mixed', 'The artist that performed this album or recording.');
        $this->registerArgument('duration', 'mixed', 'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.');
        $this->registerArgument('inAlbum', 'mixed', 'The album to which this recording belongs.');
        $this->registerArgument('inPlaylist', 'mixed', 'The playlist to which this recording belongs.');
        $this->registerArgument('isrcCode', 'mixed', 'The International Standard Recording Code for the recording.');
        $this->registerArgument('recordingOf', 'mixed', 'The composition this track is a recording of.');
    }
}
