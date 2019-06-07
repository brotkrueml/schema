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
 * A media season e.g. tv, radio, video game etc.
 *
 * schema.org version 3.6
 */
class CreativeWorkSeasonViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('endDate', 'mixed', 'The end date and time of the item (in ISO 8601 date format).');
        $this->registerArgument('episode', 'mixed', 'An episode of a tv, radio or game media within a series or season.');
        $this->registerArgument('numberOfEpisodes', 'mixed', 'The number of episodes in this season or series.');
        $this->registerArgument('partOfSeries', 'mixed', 'The series to which this episode or season belongs.');
        $this->registerArgument('productionCompany', 'mixed', 'The production company or studio responsible for the item e.g. series, video game, episode etc.');
        $this->registerArgument('seasonNumber', 'mixed', 'Position of the season within an ordered group of seasons.');
        $this->registerArgument('startDate', 'mixed', 'The start date and time of the item (in ISO 8601 date format).');
        $this->registerArgument('trailer', 'mixed', 'The trailer of a movie or tv/radio series, season, episode, etc.');
    }
}
