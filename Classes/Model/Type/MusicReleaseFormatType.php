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
 * Format of this release (the type of recording media used, ie. compact disc, digital media, LP, etc.).
 */
class MusicReleaseFormatType extends AbstractType
{
    use TypeTrait\ThingTrait;
}
