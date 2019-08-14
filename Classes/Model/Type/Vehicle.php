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
 * A vehicle is a device that is designed or used to transport people or cargo over land, water, air, or through space.
 */
final class Vehicle extends AbstractType
{
    use TypeTrait\ProductTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\VehicleTrait;
}
