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
 * A screening of a movie or other video.
 *
 * schema.org version 3.6
 */
class ScreeningEventViewHelper extends EventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('subtitleLanguage', 'mixed', 'Languages in which subtitles/captions are available, in IETF BCP 47 standard format.');
        $this->registerArgument('videoFormat', 'mixed', 'The type of screening or video broadcast used (e.g. IMAX, 3D, SD, HD, etc.).');
        $this->registerArgument('workPresented', 'mixed', 'The movie presented during this event.');
    }
}
