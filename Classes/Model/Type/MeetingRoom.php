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
 * A meeting room, conference room, or conference hall is a room provided for singular events such as business conferences and meetings (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Conference_hall).
 */
class MeetingRoom extends AbstractType
{
    use TypeTrait\AccommodationTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
