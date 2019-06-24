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
 * A hostel - cheap accommodation, often in shared dormitories.
 */
class Hostel extends AbstractType
{
    use TypeTrait\LodgingBusinessTrait;
    use TypeTrait\LocalBusinessTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\OrganizationTrait;
}
