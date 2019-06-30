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
 * A house is a building or structure that has the ability to be occupied for habitation by humans or other creatures (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/House).
 */
class House extends AbstractType
{
    use TypeTrait\AccommodationTrait;
    use TypeTrait\HouseTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
