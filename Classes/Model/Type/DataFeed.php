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
 * A single feed providing structured information about one or more entities or topics.
 */
class DataFeed extends AbstractType
{
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\DataFeedTrait;
    use TypeTrait\DatasetTrait;
    use TypeTrait\ThingTrait;
}
