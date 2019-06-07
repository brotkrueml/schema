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
 * A media episode (e.g. TV, radio, video game) which can be part of a series or season.
 *
 * schema.org version 3.6
 */
class EpisodeViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('episodeNumber', 'mixed', 'Position of the episode within an ordered group of episodes.');
        $this->registerArgument('musicBy', 'mixed', 'The composer of the soundtrack.');
        $this->registerArgument('partOfSeason', 'mixed', 'The season to which this episode belongs.');
        $this->registerArgument('partOfSeries', 'mixed', 'The series to which this episode or season belongs.');
        $this->registerArgument('productionCompany', 'mixed', 'The production company or studio responsible for the item e.g. series, video game, episode etc.');
        $this->registerArgument('trailer', 'mixed', 'The trailer of a movie or tv/radio series, season, episode, etc.');
    }
}
