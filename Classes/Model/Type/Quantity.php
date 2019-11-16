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
 * Quantities such as distance, time, mass, weight, etc. Particular instances of say Mass are entities like \&#039;3 Kg\&#039; or \&#039;4 milligrams\&#039;.
 */
final class Quantity extends AbstractType
{
    use TypeTrait\ThingTrait;
}
