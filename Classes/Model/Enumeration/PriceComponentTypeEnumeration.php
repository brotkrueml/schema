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
 * Enumerates different price components that together make up the total price for an offered product.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum PriceComponentTypeEnumeration implements EnumerationInterface
{
    /**
     * Represents the activation fee part of the total price for an offered product, for example a cellphone contract.
     */
    case ActivationFee;

    /**
     * Represents the cleaning fee part of the total price for an offered product, for example a vacation rental.
     */
    case CleaningFee;

    /**
     * Represents the distance fee (e.g., price per km or mile) part of the total price for an offered product, for example a car rental.
     */
    case DistanceFee;

    /**
     * Represents the downpayment (up-front payment) price component of the total price for an offered product that has additional installment payments.
     */
    case Downpayment;

    /**
     * Represents the installment pricing component of the total price for an offered product.
     */
    case Installment;

    /**
     * Represents the subscription pricing component of the total price for an offered product.
     */
    case Subscription;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
