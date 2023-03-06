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
 * A statement of the money due for goods or services; a bill.
 */
#[Type('Invoice')]
final class Invoice extends AbstractType
{
    protected static $propertyNames = [
        'accountId',
        'additionalType',
        'alternateName',
        'billingPeriod',
        'broker',
        'category',
        'confirmationNumber',
        'customer',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'minimumPaymentDue',
        'name',
        'paymentDueDate',
        'paymentMethod',
        'paymentMethodId',
        'paymentStatus',
        'potentialAction',
        'referencesOrder',
        'sameAs',
        'scheduledPaymentDate',
        'subjectOf',
        'totalPaymentDue',
        'url',
    ];
}
