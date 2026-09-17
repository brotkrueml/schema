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
 * Enumerates a purchase type for an item.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum PurchaseType implements EnumerationInterface
{
    /**
     * This is a lease of an item.
     */
    case PurchaseTypeLease;

    /**
     * This is a purchase of a new item.
     */
    case PurchaseTypeNewPurchase;

    /**
     * This is a trade-in for an item.
     */
    case PurchaseTypeTradeIn;

    /**
     * This is a purchase of a used item.
     */
    case PurchaseTypeUsedPurchase;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
