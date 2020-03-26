<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * Nutritional information about the recipe.
 */
final class NutritionInformation extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'calories',
        'carbohydrateContent',
        'cholesterolContent',
        'description',
        'disambiguatingDescription',
        'fatContent',
        'fiberContent',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'potentialAction',
        'proteinContent',
        'sameAs',
        'saturatedFatContent',
        'servingSize',
        'sodiumContent',
        'subjectOf',
        'sugarContent',
        'transFatContent',
        'unsaturatedFatContent',
        'url',
    ];
}
