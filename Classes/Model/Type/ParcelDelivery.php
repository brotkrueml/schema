<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * The delivery of a parcel either via the postal service or a commercial service.
 */
final class ParcelDelivery extends AbstractType
{
    use TypeTrait\ParcelDeliveryTrait;
    use TypeTrait\ThingTrait;
}
