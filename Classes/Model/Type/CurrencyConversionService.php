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
 * A service to convert funds from one currency to another currency.
 */
final class CurrencyConversionService extends AbstractType
{
    use TypeTrait\FinancialProductTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
