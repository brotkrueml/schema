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
 * An order is a confirmation of a transaction (a receipt), which can contain multiple line items, each represented by an Offer that has been accepted by the customer.
 */
final class Order extends AbstractType
{
    protected static $propertyNames = [
        'acceptedOffer',
        'additionalType',
        'alternateName',
        'billingAddress',
        'broker',
        'confirmationNumber',
        'customer',
        'description',
        'disambiguatingDescription',
        'discount',
        'discountCode',
        'discountCurrency',
        'identifier',
        'image',
        'isGift',
        'mainEntityOfPage',
        'name',
        'orderDate',
        'orderDelivery',
        'orderNumber',
        'orderStatus',
        'orderedItem',
        'partOfInvoice',
        'paymentDueDate',
        'paymentMethod',
        'paymentMethodId',
        'paymentUrl',
        'potentialAction',
        'sameAs',
        'seller',
        'subjectOf',
        'url',
    ];
}
