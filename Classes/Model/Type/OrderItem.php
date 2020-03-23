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
 * An order item is a line of an order. It includes the quantity and shipping details of a bought offer.
 */
final class OrderItem extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'orderDelivery',
        'orderItemNumber',
        'orderItemStatus',
        'orderQuantity',
        'orderedItem',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
