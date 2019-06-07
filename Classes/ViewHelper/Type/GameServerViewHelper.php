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
 * Server that provides game interaction in a multiplayer game.
 *
 * schema.org version 3.6
 */
class GameServerViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('game', 'mixed', 'Video game which is played on this server.');
        $this->registerArgument('playersOnline', 'mixed', 'Number of players on the server.');
        $this->registerArgument('serverStatus', 'mixed', 'Status of a game server.');
    }
}
