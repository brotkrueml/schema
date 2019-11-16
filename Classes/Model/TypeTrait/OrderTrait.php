<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

trait OrderTrait
{
    protected $acceptedOffer;
    protected $billingAddress;
    protected $broker;
    protected $confirmationNumber;
    protected $customer;
    protected $discount;
    protected $discountCode;
    protected $discountCurrency;
    protected $isGift;
    protected $orderDate;
    protected $orderDelivery;
    protected $orderNumber;
    protected $orderStatus;
    protected $orderedItem;
    protected $partOfInvoice;
    protected $paymentDueDate;
    protected $paymentMethod;
    protected $paymentMethodId;
    protected $paymentUrl;
    protected $seller;
}
