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
 * A range of of services that will be provided to a customer free of charge in case of a defect or malfunction of a product.
 */
final class WarrantyScope extends AbstractType
{
    use TypeTrait\ThingTrait;
}
