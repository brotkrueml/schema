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
 * A delivery service through which content is provided via broadcast over the air or online.
 */
final class BroadcastService extends AbstractType
{
    use TypeTrait\BroadcastServiceTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
