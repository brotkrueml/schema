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
 * The Game type represents things which are games. These are typically rule-governed recreational activities, e.g. role-playing games in which players assume the role of characters in a fictional setting.
 *
 * schema.org version 3.6
 */
class GameViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('characterAttribute', 'mixed', 'A piece of data that represents a particular aspect of a fictional character (skill, power, character points, advantage, disadvantage).');
        $this->registerArgument('gameItem', 'mixed', 'An item is an object within the game world that can be collected by a player or, occasionally, a non-player character.');
        $this->registerArgument('gameLocation', 'mixed', 'Real or fictional location of the game (or part of game).');
        $this->registerArgument('numberOfPlayers', 'mixed', 'Indicate how many people can play this game (minimum, maximum, or range).');
        $this->registerArgument('quest', 'mixed', 'The task that a player-controlled character, or group of characters may complete in order to gain a reward.');
    }
}
