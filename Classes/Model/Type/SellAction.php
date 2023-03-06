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
 * The act of taking money from a buyer in exchange for goods or services rendered. An agent sells an object, product, or service to a buyer for a price. Reciprocal of BuyAction.
 */
#[Type('SellAction')]
final class SellAction extends AbstractType
{
    protected static array $propertyNames = [
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'buyer',
        'description',
        'disambiguatingDescription',
        'endTime',
        'error',
        'identifier',
        'image',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
        'participant',
        'potentialAction',
        'price',
        'priceCurrency',
        'priceSpecification',
        'result',
        'sameAs',
        'startTime',
        'subjectOf',
        'target',
        'url',
    ];
}
