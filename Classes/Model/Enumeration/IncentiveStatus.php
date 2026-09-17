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
 * Enumerates a status for an incentive, such as whether it is active.
 */
enum IncentiveStatus implements EnumerationInterface
{
    /**
     * This incentive is currently active.
     */
    case IncentiveStatusActive;

    /**
     * This incentive is currently being developed, and may become active/retired in the future.
     */
    case IncentiveStatusInDevelopment;

    /**
     * This incentive is currently active, but may not be accepting new applicants (e.g. max number of redemptions reached for a year)
     */
    case IncentiveStatusOnHold;

    /**
     * This incentive is not longer available.
     */
    case IncentiveStatusRetired;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
