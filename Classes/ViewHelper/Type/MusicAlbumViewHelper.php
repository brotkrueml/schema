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
 * A collection of music tracks.
 *
 * schema.org version 3.6
 */
class MusicAlbumViewHelper extends MusicPlaylistViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('albumProductionType', 'mixed', 'Classification of the album by it\'s type of content: soundtrack, live album, studio album, etc.');
        $this->registerArgument('albumRelease', 'mixed', 'A release of this album.');
        $this->registerArgument('albumReleaseType', 'mixed', 'The kind of release which this album is: single, EP or album.');
        $this->registerArgument('byArtist', 'mixed', 'The artist that performed this album or recording.');
    }
}
