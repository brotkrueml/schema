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
 * A placeholder for multiple similar products of the same kind.
 */
#[Type('SomeProducts')]
final class SomeProducts extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
        'additionalType',
        'aggregateRating',
        'alternateName',
        'audience',
        'award',
        'brand',
        'category',
        'color',
        'countryOfOrigin',
        'depth',
        'description',
        'disambiguatingDescription',
        'gtin12',
        'gtin13',
        'gtin14',
        'gtin8',
        'hasCertification',
        'height',
        'identifier',
        'image',
        'inventoryLevel',
        'isAccessoryOrSparePartFor',
        'isConsumableFor',
        'isFamilyFriendly',
        'isRelatedTo',
        'isSimilarTo',
        'isVariantOf',
        'itemCondition',
        'keywords',
        'logo',
        'mainEntityOfPage',
        'manufacturer',
        'material',
        'model',
        'mpn',
        'name',
        'offers',
        'potentialAction',
        'productID',
        'productionDate',
        'purchaseDate',
        'releaseDate',
        'review',
        'sameAs',
        'sku',
        'slogan',
        'subjectOf',
        'url',
        'weight',
        'width',
    ];
}
