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
 * A service for a vehicle for hire with a driver for local travel. Fares are usually calculated based on distance traveled.
 */
class TaxiService extends AbstractType
{
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
