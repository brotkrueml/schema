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
 * An apartment (in American English) or flat (in British English) is a self-contained housing unit (a type of residential real estate) that occupies only part of a building (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Apartment).
 */
final class Apartment extends AbstractType
{
    use TypeTrait\AccommodationTrait;
    use TypeTrait\ApartmentTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
