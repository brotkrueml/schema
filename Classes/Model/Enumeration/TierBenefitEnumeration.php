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
 * An enumeration of possible benefits as part of a loyalty (members) program.
 */
enum TierBenefitEnumeration implements EnumerationInterface
{
    /**
     * Benefit of the tier is earning of loyalty points.
     */
    case TierBenefitLoyaltyPoints;

    /**
     * Benefit of the tier is a members-only price.
     */
    case TierBenefitLoyaltyPrice;

    /**
     * Benefit of the tier is members-only returns, for example free unlimited returns.
     */
    case TierBenefitLoyaltyReturns;

    /**
     * Benefit of the tier is a members-only shipping price or speed (for example free shipping or 1-day shipping).
     */
    case TierBenefitLoyaltyShipping;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
