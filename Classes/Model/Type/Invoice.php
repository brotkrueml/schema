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
    protected $properties = [
        'accountId' => null,
        'additionalType' => null,
        'alternateName' => null,
        'billingPeriod' => null,
        'broker' => null,
        'category' => null,
        'confirmationNumber' => null,
        'customer' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'minimumPaymentDue' => null,
        'name' => null,
        'paymentDueDate' => null,
        'paymentMethod' => null,
        'paymentMethodId' => null,
        'paymentStatus' => null,
        'potentialAction' => null,
        'provider' => null,
        'referencesOrder' => null,
        'sameAs' => null,
        'scheduledPaymentDate' => null,
        'subjectOf' => null,
        'totalPaymentDue' => null,
        'url' => null,
    ];
}
