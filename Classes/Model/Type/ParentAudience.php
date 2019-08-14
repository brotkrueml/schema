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
 * A set of characteristics describing parents, who can be interested in viewing some content.
 */
final class ParentAudience extends AbstractType
{
    use TypeTrait\AudienceTrait;
    use TypeTrait\ParentAudienceTrait;
    use TypeTrait\PeopleAudienceTrait;
    use TypeTrait\ThingTrait;
}
