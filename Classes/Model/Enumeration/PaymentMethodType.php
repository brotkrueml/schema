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
 * The type of payment method, only for generic payment types, specific forms of payments, like card payment should be expressed using subclasses of PaymentMethod.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum PaymentMethodType implements EnumerationInterface
{
    /**
     * Payment in advance by bank transfer, equivalent to http://purl.org/goodrelations/v1#ByBankTransferInAdvance.
     */
    case ByBankTransferInAdvance;

    /**
     * Payment by invoice, typically after the goods were delivered, equivalent to http://purl.org/goodrelations/v1#ByInvoice.
     */
    case ByInvoice;

    /**
     * Cash on Delivery (COD) payment, equivalent to http://purl.org/goodrelations/v1#COD.
     */
    case COD;

    /**
     * Payment using cash, on premises, equivalent to http://purl.org/goodrelations/v1#Cash.
     */
    case Cash;

    /**
     * Payment in advance by sending a check, equivalent to http://purl.org/goodrelations/v1#CheckInAdvance.
     */
    case CheckInAdvance;

    /**
     * Payment in advance by direct debit from the bank, equivalent to http://purl.org/goodrelations/v1#DirectDebit.
     */
    case DirectDebit;

    /**
     * Payment in advance in some form of shop or kiosk for goods purchased online.
     */
    case InStorePrepay;

    /**
     * Payment by billing via the phone carrier.
     */
    case PhoneCarrierPayment;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
