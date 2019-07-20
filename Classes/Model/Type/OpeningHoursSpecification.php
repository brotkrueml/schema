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
 * A structured value providing information about the opening hours of a place or a certain service inside a place.
 */
final class OpeningHoursSpecification extends AbstractType
{
    use TypeTrait\OpeningHoursSpecificationTrait;
    use TypeTrait\ThingTrait;
}
