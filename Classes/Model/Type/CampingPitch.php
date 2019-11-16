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
 * A CampingPitch is an individual place for overnight stay in the outdoors, typically being part of a larger camping site, or Campground.
 */
final class CampingPitch extends AbstractType
{
    use TypeTrait\AccommodationTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
