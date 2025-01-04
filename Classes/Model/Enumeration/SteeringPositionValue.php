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
 * A value indicating a steering position.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum SteeringPositionValue implements EnumerationInterface
{
    /**
     * The steering position is on the left side of the vehicle (viewed from the main direction of driving).
     */
    case LeftHandDriving;

    /**
     * The steering position is on the right side of the vehicle (viewed from the main direction of driving).
     */
    case RightHandDriving;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
