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
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A trip or journey. An itinerary of visits to one or more places.
 */
final class Trip extends AbstractType
{
    use TypeTrait\ThingTrait;
    use TypeTrait\TripTrait;
}
