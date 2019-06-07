<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A video game is an electronic game that involves human interaction with a user interface to generate visual feedback on a video device.
 *
 * schema.org version 3.6
 */
class VideoGame extends SoftwareApplication
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('actor', 'characterAttribute', 'cheatCode', 'director', 'gameItem', 'gameLocation', 'gamePlatform', 'gameServer', 'gameTip', 'musicBy', 'numberOfPlayers', 'playMode', 'quest', 'trailer');
    }
}
