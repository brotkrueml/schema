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
 * A set of characteristics belonging to people, e.g. who compose an item\&#039;s target audience.
 */
final class PeopleAudience extends AbstractType
{
    use TypeTrait\AudienceTrait;
    use TypeTrait\PeopleAudienceTrait;
    use TypeTrait\ThingTrait;
}
