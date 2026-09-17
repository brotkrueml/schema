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
 * For a VideoGame, such as used with a PlayGameAction, an enumeration of the kind of game availability offered.
 */
enum GameAvailabilityEnumeration implements EnumerationInterface
{
    /**
     * Indicates demo game availability, i.e. a somehow limited demonstration of the full game.
     */
    case DemoGameAvailability;

    /**
     * Indicates full game availability.
     */
    case FullGameAvailability;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
