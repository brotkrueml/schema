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
 * A rating is an evaluation on a numeric scale, such as 1 to 5 stars.
 */
final class Rating extends AbstractType
{
    use TypeTrait\RatingTrait;
    use TypeTrait\ThingTrait;
}
