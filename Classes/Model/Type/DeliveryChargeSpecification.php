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
 * The price for the delivery of an offer using a particular delivery method.
 */
class DeliveryChargeSpecification extends AbstractType
{
    use TypeTrait\DeliveryChargeSpecificationTrait;
    use TypeTrait\PriceSpecificationTrait;
    use TypeTrait\ThingTrait;
}
