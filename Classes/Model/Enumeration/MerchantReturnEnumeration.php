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
 * Enumerates several kinds of product return policies.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum MerchantReturnEnumeration implements EnumerationInterface
{
    /**
     * Specifies that there is a finite window for product returns.
     */
    case MerchantReturnFiniteReturnWindow;

    /**
     * Specifies that product returns are not permitted.
     */
    case MerchantReturnNotPermitted;

    /**
     * Specifies that there is an unlimited window for product returns.
     */
    case MerchantReturnUnlimitedWindow;

    /**
     * Specifies that a product return policy is not provided.
     */
    case MerchantReturnUnspecified;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
