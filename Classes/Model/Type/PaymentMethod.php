<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

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
 * Structured values are recommended for newer payment methods.
 */
#[Type('PaymentMethod')]
final class PaymentMethod extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
