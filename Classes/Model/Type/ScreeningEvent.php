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
 * A screening of a movie or other video.
 */
final class ScreeningEvent extends AbstractType
{
    use TypeTrait\EventTrait;
    use TypeTrait\ScreeningEventTrait;
    use TypeTrait\ThingTrait;
}
