<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class MusicRecording extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('byArtist', 'duration', 'inAlbum', 'inPlaylist', 'isrcCode', 'recordingOf');
    }
}
