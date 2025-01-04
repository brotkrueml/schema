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
 * Status of a game server.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum GameServerStatus implements EnumerationInterface
{
    /**
     * Game server status: OfflinePermanently. Server is offline and not available.
     */
    case OfflinePermanently;

    /**
     * Game server status: OfflineTemporarily. Server is offline now but it can be online soon.
     */
    case OfflineTemporarily;

    /**
     * Game server status: Online. Server is available.
     */
    case Online;

    /**
     * Game server status: OnlineFull. Server is online but unavailable. The maximum number of players has reached.
     */
    case OnlineFull;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
