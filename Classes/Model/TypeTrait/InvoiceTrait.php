<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
trait InvoiceTrait
{
    protected $accountId;
    protected $billingPeriod;
    protected $broker;
    protected $category;
    protected $confirmationNumber;
    protected $customer;
    protected $minimumPaymentDue;
    protected $paymentDueDate;
    protected $paymentMethod;
    protected $paymentMethodId;
    protected $paymentStatus;
    protected $provider;
    protected $referencesOrder;
    protected $scheduledPaymentDate;
    protected $totalPaymentDue;
}
