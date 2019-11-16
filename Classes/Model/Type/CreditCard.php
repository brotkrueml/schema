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
 * A card payment method of a particular brand or name.  Used to mark up a particular payment method and/or the financial product/service that supplies the card account.
 */
final class CreditCard extends AbstractType
{
    use TypeTrait\FinancialProductTrait;
    use TypeTrait\LoanOrCreditTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
