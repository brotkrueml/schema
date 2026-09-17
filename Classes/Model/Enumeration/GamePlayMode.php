<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * Indicates whether this game is multi-player, co-op or single-player.
 */
enum GamePlayMode implements EnumerationInterface
{
    /**
     * Play mode: CoOp. Co-operative games, where you play on the same team with friends.
     */
    case CoOp;

    /**
     * Play mode: MultiPlayer. Requiring or allowing multiple human players to play simultaneously.
     */
    case MultiPlayer;

    /**
     * Play mode: SinglePlayer. Which is played by a lone player.
     */
    case SinglePlayer;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
