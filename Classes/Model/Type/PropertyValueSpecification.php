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
 * A Property value specification.
 */
final class PropertyValueSpecification extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'defaultValue' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'maxValue' => null,
        'minValue' => null,
        'multipleValues' => null,
        'name' => null,
        'potentialAction' => null,
        'readonlyValue' => null,
        'sameAs' => null,
        'stepValue' => null,
        'subjectOf' => null,
        'url' => null,
        'valueMaxLength' => null,
        'valueMinLength' => null,
        'valueName' => null,
        'valuePattern' => null,
        'valueRequired' => null,
    ];
}
