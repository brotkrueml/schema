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
 * Enumerates several types of product return methods.
 */
enum ReturnMethodEnumeration implements EnumerationInterface
{
    /**
     * Specifies that the consumer can keep the product, even when receiving a refund or store credit.
     */
    case KeepProduct;

    /**
     * Specifies that product returns must be made at a kiosk.
     */
    case ReturnAtKiosk;

    /**
     * Specifies that product returns must be done by mail.
     */
    case ReturnByMail;

    /**
     * Specifies that product returns must be made in a store.
     */
    case ReturnInStore;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
