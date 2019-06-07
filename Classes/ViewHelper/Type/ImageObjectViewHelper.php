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
 * An image file.
 *
 * schema.org version 3.6
 */
class ImageObjectViewHelper extends MediaObjectViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('caption', 'mixed', 'The caption for this object. For downloadable machine formats (closed caption, subtitles etc.) use MediaObject and indicate the encodingFormat.');
        $this->registerArgument('exifData', 'mixed', 'exif data for this object.');
        $this->registerArgument('representativeOfPage', 'mixed', 'Indicates whether this image is representative of the content of the page.');
        $this->registerArgument('thumbnail', 'mixed', 'Thumbnail image for an image or video.');
    }
}
