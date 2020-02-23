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
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 */
final class Product extends AbstractType
{
    protected $properties = [
        'additionalProperty' => null,
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'audience' => null,
        'award' => null,
        'brand' => null,
        'category' => null,
        'color' => null,
        'depth' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'gtin12' => null,
        'gtin13' => null,
        'gtin14' => null,
        'gtin8' => null,
        'height' => null,
        'identifier' => null,
        'image' => null,
        'isAccessoryOrSparePartFor' => null,
        'isConsumableFor' => null,
        'isRelatedTo' => null,
        'isSimilarTo' => null,
        'itemCondition' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'manufacturer' => null,
        'material' => null,
        'model' => null,
        'mpn' => null,
        'name' => null,
        'offers' => null,
        'potentialAction' => null,
        'productID' => null,
        'productionDate' => null,
        'purchaseDate' => null,
        'releaseDate' => null,
        'review' => null,
        'sameAs' => null,
        'sku' => null,
        'slogan' => null,
        'subjectOf' => null,
        'url' => null,
        'weight' => null,
        'width' => null,
    ];
}
