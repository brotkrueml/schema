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
 * A specific payment status. For example, PaymentDue, PaymentComplete, etc.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum PaymentStatusType implements EnumerationInterface
{
    /**
     * An automatic payment system is in place and will be used.
     */
    case PaymentAutomaticallyApplied;

    /**
     * The payment has been received and processed.
     */
    case PaymentComplete;

    /**
     * The payee received the payment, but it was declined for some reason.
     */
    case PaymentDeclined;

    /**
     * The payment is due, but still within an acceptable time to be received.
     */
    case PaymentDue;

    /**
     * The payment is due and considered late.
     */
    case PaymentPastDue;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
