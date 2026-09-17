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
 * Enumerates several kinds of policies for product return fees.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum ReturnFeesEnumeration implements EnumerationInterface
{
    /**
     * Specifies that product returns are free of charge for the customer.
     */
    case FreeReturn;

    /**
     * Specifies that the customer must pay the original shipping costs when returning a product.
     */
    case OriginalShippingFees;

    /**
     * Specifies that the customer must pay a restocking fee when returning a product.
     */
    case RestockingFees;

    /**
     * Specifies that product returns must be paid for, and are the responsibility of, the customer.
     */
    case ReturnFeesCustomerResponsibility;

    /**
     * Specifies that the customer must pay the return shipping costs when returning a product.
     */
    case ReturnShippingFees;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
