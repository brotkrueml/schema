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
 * A MusicRelease is a specific release of a music album.
 *
 * schema.org version 3.6
 */
class MusicReleaseViewHelper extends MusicPlaylistViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('catalogNumber', 'mixed', 'The catalog number for the release.');
        $this->registerArgument('creditedTo', 'mixed', 'The group the release is credited to if different than the byArtist. For example, Red and Blue is credited to "Stefani Germanotta Band", but by Lady Gaga.');
        $this->registerArgument('duration', 'mixed', 'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.');
        $this->registerArgument('musicReleaseFormat', 'mixed', 'Format of this release (the type of recording media used, ie. compact disc, digital media, LP, etc.).');
        $this->registerArgument('recordLabel', 'mixed', 'The label that issued the release.');
        $this->registerArgument('releaseOf', 'mixed', 'The album this is a release of.');
    }
}
