<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A statement of the money due for goods or services; a bill.
 */
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
        'provider',
        'referencesOrder',
        'sameAs',
        'scheduledPaymentDate',
        'subjectOf',
        'totalPaymentDue',
        'url',
    ];
}
