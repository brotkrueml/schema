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
 * Enumerates several kinds of product return refund types.
 */
enum RefundTypeEnumeration implements EnumerationInterface
{
    /**
     * Specifies that a refund can be done as an exchange for the same product.
     */
    case ExchangeRefund;

    /**
     * Specifies that a refund can be done in the full amount the customer paid for the product.
     */
    case FullRefund;

    /**
     * Specifies that the customer receives a store credit as refund when returning a product.
     */
    case StoreCreditRefund;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
