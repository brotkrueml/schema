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
 * Properties that take Distances as values are of the form \&#039;&amp;lt;Number&amp;gt; &amp;lt;Length unit of measure&amp;gt;\&#039;. E.g., \&#039;7 ft\&#039;.
 */
final class Distance extends AbstractType
{
    use TypeTrait\ThingTrait;
}
