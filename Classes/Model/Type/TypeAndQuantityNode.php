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
 * A structured value indicating the quantity, unit of measurement, and business function of goods included in a bundle offer.
 */
#[Type('TypeAndQuantityNode')]
final class TypeAndQuantityNode extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'amountOfThisGood',
        'businessFunction',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'typeOfGood',
        'unitCode',
        'unitText',
        'url',
    ];
}
