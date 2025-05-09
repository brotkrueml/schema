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
 * A datasheet or vendor specification of a product (in the sense of a prototypical description).
 */
#[Type('ProductModel')]
final class ProductModel extends AbstractType
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
        'description',
        'disambiguatingDescription',
        'gtin12',
        'gtin13',
        'gtin14',
        'gtin8',
        'hasCertification',
        'identifier',
        'image',
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
        'predecessorOf',
        'productID',
        'productionDate',
        'purchaseDate',
        'releaseDate',
        'review',
        'sameAs',
        'sku',
        'slogan',
        'subjectOf',
        'successorOf',
        'url',
    ];
}
