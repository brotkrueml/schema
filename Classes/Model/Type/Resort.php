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
 * A resort is a place used for relaxation or recreation, attracting visitors for holidays or vacations. Resorts are places, towns or sometimes commercial establishment operated by a single company (Source: Wikipedia, the free encyclopedia, see http://en.wikipedia.org/wiki/Resort).
 */
final class Resort extends AbstractType
{
    use TypeTrait\LocalBusinessTrait;
    use TypeTrait\LodgingBusinessTrait;
    use TypeTrait\OrganizationTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
