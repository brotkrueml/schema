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
 * A payment method using a credit, debit, store or other card to associate the payment with an account.
 */
final class PaymentCard extends AbstractType
{
    use TypeTrait\FinancialProductTrait;
    use TypeTrait\ServiceTrait;
    use TypeTrait\ThingTrait;
}
