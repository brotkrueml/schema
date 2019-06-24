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
 * A hotel is an establishment that provides lodging paid on a short-term basis (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Hotel).
 */
class Hotel extends AbstractType
{
    use TypeTrait\LocalBusinessTrait;
    use TypeTrait\LodgingBusinessTrait;
    use TypeTrait\OrganizationTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
