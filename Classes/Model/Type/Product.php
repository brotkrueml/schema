<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * schema.org version 3.6
 */
class Product extends Thing
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('additionalProperty', 'aggregateRating', 'audience', 'award', 'brand', 'category', 'color', 'depth', 'gtin12', 'gtin13', 'gtin14', 'gtin8', 'height', 'isAccessoryOrSparePartFor', 'isConsumableFor', 'isRelatedTo', 'isSimilarTo', 'itemCondition', 'logo', 'manufacturer', 'material', 'model', 'mpn', 'offers', 'productID', 'productionDate', 'purchaseDate', 'releaseDate', 'review', 'sku', 'slogan', 'weight', 'width');
    }
}
