<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A datasheet or vendor specification of a product (in the sense of a prototypical description).
 */
class ProductModel extends AbstractType
{
    use TypeTrait\ProductTrait;
    use TypeTrait\ProductModelTrait;
    use TypeTrait\ThingTrait;
}
