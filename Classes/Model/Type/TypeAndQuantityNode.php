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
 * A structured value indicating the quantity, unit of measurement, and business function of goods included in a bundle offer.
 */
final class TypeAndQuantityNode extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'amountOfThisGood' => null,
        'businessFunction' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'typeOfGood' => null,
        'unitCode' => null,
        'unitText' => null,
        'url' => null,
    ];
}
