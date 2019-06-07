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
 * A video file.
 *
 * schema.org version 3.6
 */
class VideoObjectViewHelper extends MediaObjectViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('caption', 'mixed', 'The caption for this object. For downloadable machine formats (closed caption, subtitles etc.) use MediaObject and indicate the encodingFormat.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('musicBy', 'mixed', 'The composer of the soundtrack.');
        $this->registerArgument('thumbnail', 'mixed', 'Thumbnail image for an image or video.');
        $this->registerArgument('transcript', 'mixed', 'If this MediaObject is an AudioObject or VideoObject, the transcript of that object.');
        $this->registerArgument('videoFrameSize', 'mixed', 'The frame size of the video.');
        $this->registerArgument('videoQuality', 'mixed', 'The quality of the video.');
    }
}
