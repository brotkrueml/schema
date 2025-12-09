<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A payment method is a standardized procedure for transferring the monetary amount for a purchase. Payment methods are characterized by the legal and technical structures used, and by the organization or group carrying out the transaction. The following legacy values should be accepted:
 * http://purl.org/goodrelations/v1#ByBankTransferInAdvance
 * http://purl.org/goodrelations/v1#ByInvoice
 * http://purl.org/goodrelations/v1#Cash
 * http://purl.org/goodrelations/v1#CheckInAdvance
 * http://purl.org/goodrelations/v1#COD
 * http://purl.org/goodrelations/v1#DirectDebit
 * http://purl.org/goodrelations/v1#GoogleCheckout
 * http://purl.org/goodrelations/v1#PayPal
 * http://purl.org/goodrelations/v1#PaySwarm
 *
 * Structured values, or [UNCE payment means](https://vocabulary.uncefact.org/PaymentMeans) are recommended or for newer annotations.
 */
final class PaymentMethodViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'PaymentMethod';
}
