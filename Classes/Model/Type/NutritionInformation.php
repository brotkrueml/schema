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
 * Nutritional information about the recipe.
 */
final class NutritionInformation extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'calories' => null,
        'carbohydrateContent' => null,
        'cholesterolContent' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'fatContent' => null,
        'fiberContent' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'proteinContent' => null,
        'sameAs' => null,
        'saturatedFatContent' => null,
        'servingSize' => null,
        'sodiumContent' => null,
        'subjectOf' => null,
        'sugarContent' => null,
        'transFatContent' => null,
        'unsaturatedFatContent' => null,
        'url' => null,
    ];
}
