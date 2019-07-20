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
 * A camping site, campsite, or Campground is a place used for overnight stay in the outdoors, typically containing individual CampingPitch locations.
 */
final class Campground extends AbstractType
{
    use TypeTrait\CivicStructureTrait;
    use TypeTrait\LocalBusinessTrait;
    use TypeTrait\LodgingBusinessTrait;
    use TypeTrait\OrganizationTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
