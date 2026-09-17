<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 */
#[Type('Product')]
#[Manual(Publisher::Google, 'Product', 'https://developers.google.com/search/docs/appearance/structured-data/product')]
#[Manual(Publisher::Google, 'Product variant', 'https://developers.google.com/search/docs/appearance/structured-data/product-variants')]
#[Manual(Publisher::Google, 'Merchant listing', 'https://developers.google.com/search/docs/appearance/structured-data/merchant-listing')]
#[Manual(Publisher::Yandex, 'Product information', 'https://yandex.com/support/webmaster/supported-schemas/goods-prices.html')]
final class Product extends AbstractType
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
        'countryOfAssembly',
        'countryOfLastProcessing',
        'countryOfOrigin',
        'depth',
        'description',
        'disambiguatingDescription',
        'funding',
        'gtin12',
        'gtin13',
        'gtin14',
        'gtin8',
        'hasCertification',
        'hasEnergyConsumptionDetails',
        'hasGS1DigitalLink',
        'hasMeasurement',
        'hasMerchantReturnPolicy',
        'height',
        'identifier',
        'image',
        'inProductGroupWithID',
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
        'negativeNotes',
        'nsn',
        'offers',
        'owner',
        'pattern',
        'positiveNotes',
        'potentialAction',
        'productID',
        'productionDate',
        'purchaseDate',
        'releaseDate',
        'review',
        'sameAs',
        'size',
        'sku',
        'slogan',
        'subjectOf',
        'url',
        'weight',
        'width',
    ];
}
