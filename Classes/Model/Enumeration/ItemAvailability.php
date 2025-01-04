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
 * A list of possible product availability options.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum ItemAvailability implements EnumerationInterface
{
    /**
     * Indicates that the item is available on back order.
     */
    case BackOrder;

    /**
     * Indicates that the item has been discontinued.
     */
    case Discontinued;

    /**
     * Indicates that the item is in stock.
     */
    case InStock;

    /**
     * Indicates that the item is available only at physical locations.
     */
    case InStoreOnly;

    /**
     * Indicates that the item has limited availability.
     */
    case LimitedAvailability;

    /**
     * Indicates that the item is made to order (custom made).
     */
    case MadeToOrder;

    /**
     * Indicates that the item is available only online.
     */
    case OnlineOnly;

    /**
     * Indicates that the item is out of stock.
     */
    case OutOfStock;

    /**
     * Indicates that the item is available for pre-order.
     */
    case PreOrder;

    /**
     * Indicates that the item is available for ordering and delivery before general availability.
     */
    case PreSale;

    /**
     * Indicates that the item is reserved and therefore not available.
     */
    case Reserved;

    /**
     * Indicates that the item has sold out.
     */
    case SoldOut;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
