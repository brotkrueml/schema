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
 * A structured value providing information about when a certain organization or person owned a certain product.
 */
final class OwnershipInfo extends AbstractType
{
    use TypeTrait\OwnershipInfoTrait;
    use TypeTrait\ThingTrait;
}
