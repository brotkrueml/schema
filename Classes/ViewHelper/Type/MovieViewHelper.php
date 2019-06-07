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
 * A movie.
 *
 * schema.org version 3.6
 */
class MovieViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('countryOfOrigin', 'mixed', 'The country of the principal offices of the production company or individual responsible for the movie or program.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('duration', 'mixed', 'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.');
        $this->registerArgument('musicBy', 'mixed', 'The composer of the soundtrack.');
        $this->registerArgument('productionCompany', 'mixed', 'The production company or studio responsible for the item e.g. series, video game, episode etc.');
        $this->registerArgument('subtitleLanguage', 'mixed', 'Languages in which subtitles/captions are available, in IETF BCP 47 standard format.');
        $this->registerArgument('trailer', 'mixed', 'The trailer of a movie or tv/radio series, season, episode, etc.');
    }
}
