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
 * A video game series.
 *
 * schema.org version 3.6
 */
class VideoGameSeriesViewHelper extends CreativeWorkSeriesViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('characterAttribute', 'mixed', 'A piece of data that represents a particular aspect of a fictional character (skill, power, character points, advantage, disadvantage).');
        $this->registerArgument('cheatCode', 'mixed', 'Cheat codes to the game.');
        $this->registerArgument('containsSeason', 'mixed', 'A season that is part of the media series.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('episode', 'mixed', 'An episode of a tv, radio or game media within a series or season.');
        $this->registerArgument('gameItem', 'mixed', 'An item is an object within the game world that can be collected by a player or, occasionally, a non-player character.');
        $this->registerArgument('gameLocation', 'mixed', 'Real or fictional location of the game (or part of game).');
        $this->registerArgument('gamePlatform', 'mixed', 'The electronic systems used to play video games.');
        $this->registerArgument('musicBy', 'mixed', 'The composer of the soundtrack.');
        $this->registerArgument('numberOfEpisodes', 'mixed', 'The number of episodes in this season or series.');
        $this->registerArgument('numberOfPlayers', 'mixed', 'Indicate how many people can play this game (minimum, maximum, or range).');
        $this->registerArgument('numberOfSeasons', 'mixed', 'The number of seasons in this series.');
        $this->registerArgument('playMode', 'mixed', 'Indicates whether this game is multi-player, co-op or single-player.  The game can be marked as multi-player, co-op and single-player at the same time.');
        $this->registerArgument('productionCompany', 'mixed', 'The production company or studio responsible for the item e.g. series, video game, episode etc.');
        $this->registerArgument('quest', 'mixed', 'The task that a player-controlled character, or group of characters may complete in order to gain a reward.');
        $this->registerArgument('trailer', 'mixed', 'The trailer of a movie or tv/radio series, season, episode, etc.');
    }
}
