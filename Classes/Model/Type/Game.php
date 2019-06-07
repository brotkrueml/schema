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
 * The Game type represents things which are games. These are typically rule-governed recreational activities, e.g. role-playing games in which players assume the role of characters in a fictional setting.
 *
 * schema.org version 3.6
 */
class Game extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('characterAttribute', 'gameItem', 'gameLocation', 'numberOfPlayers', 'quest');
    }
}
