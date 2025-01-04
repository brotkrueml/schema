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
 * The status of an Action.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum ActionStatusType implements EnumerationInterface
{
    /**
     * An in-progress action (e.g., while watching the movie, or driving to a location).
     */
    case ActiveActionStatus;

    /**
     * An action that has already taken place.
     */
    case CompletedActionStatus;

    /**
     * An action that failed to complete. The action's error property and the HTTP return code contain more information about the failure.
     */
    case FailedActionStatus;

    /**
     * A description of an action that is supported.
     */
    case PotentialActionStatus;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
