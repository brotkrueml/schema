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
 * A type of boarding policy used by an airline.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum BoardingPolicyType implements EnumerationInterface
{
    /**
     * The airline boards by groups based on check-in time, priority, etc.
     */
    case GroupBoardingPolicy;

    /**
     * The airline boards by zones of the plane.
     */
    case ZoneBoardingPolicy;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
