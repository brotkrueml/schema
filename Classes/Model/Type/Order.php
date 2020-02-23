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
    protected $properties = [
        'acceptedOffer' => null,
        'additionalType' => null,
        'alternateName' => null,
        'billingAddress' => null,
        'broker' => null,
        'confirmationNumber' => null,
        'customer' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'discount' => null,
        'discountCode' => null,
        'discountCurrency' => null,
        'identifier' => null,
        'image' => null,
        'isGift' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'orderDate' => null,
        'orderDelivery' => null,
        'orderNumber' => null,
        'orderStatus' => null,
        'orderedItem' => null,
        'partOfInvoice' => null,
        'paymentDueDate' => null,
        'paymentMethod' => null,
        'paymentMethodId' => null,
        'paymentUrl' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'seller' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
