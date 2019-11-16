<?php
declare(strict_types=1);

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
 * A publication event e.g. catch-up TV or radio podcast, during which a program is available on-demand.
 */
final class OnDemandEvent extends AbstractType
{
    use TypeTrait\EventTrait;
    use TypeTrait\PublicationEventTrait;
    use TypeTrait\ThingTrait;
}
