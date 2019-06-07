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
 * An audio file.
 *
 * schema.org version 3.6
 */
class AudioObjectViewHelper extends MediaObjectViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('caption', 'mixed', 'The caption for this object. For downloadable machine formats (closed caption, subtitles etc.) use MediaObject and indicate the encodingFormat.');
        $this->registerArgument('transcript', 'mixed', 'If this MediaObject is an AudioObject or VideoObject, the transcript of that object.');
    }
}
