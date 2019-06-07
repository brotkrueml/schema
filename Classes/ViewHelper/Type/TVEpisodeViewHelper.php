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
 * A TV episode which can be part of a series or season.
 *
 * schema.org version 3.6
 */
class TVEpisodeViewHelper extends EpisodeViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('countryOfOrigin', 'mixed', 'The country of the principal offices of the production company or individual responsible for the movie or program.');
        $this->registerArgument('subtitleLanguage', 'mixed', 'Languages in which subtitles/captions are available, in IETF BCP 47 standard format.');
    }
}
