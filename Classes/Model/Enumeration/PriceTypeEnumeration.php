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
 * Enumerates different price types, for example list price, invoice price, and sale price.
 */
enum PriceTypeEnumeration implements EnumerationInterface
{
    /**
     * Represents the invoice price of an offered product.
     */
    case InvoicePrice;

    /**
     * Represents the list price of an offered product. Typically the same as the [MSRP](https://schema.org/MSRP).
     */
    case ListPrice;

    /**
     * Represents the manufacturer suggested retail price ("MSRP") of an offered product.
     */
    case MSRP;

    /**
     * The maximum retail price (MRP) of a product sold in India.
     */
    case MaximumRetailPrice;

    /**
     * Represents the minimum advertised price ("MAP") (as dictated by the manufacturer) of an offered product.
     */
    case MinimumAdvertisedPrice;

    /**
     * Represents the regular price of an offered product. This is usually the advertised price before a temporary sale. Once the sale period ends the advertised price will go back to the regular price.
     */
    case RegularPrice;

    /**
     * Represents the suggested retail price ("SRP") of an offered product.
     */
    case SRP;

    /**
     * Represents a sale price (usually active for a limited period) of an offered product.
     */
    case SalePrice;

    /**
     * Represents the strikethrough price (the previous advertised price) of an offered product.
     */
    case StrikethroughPrice;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
