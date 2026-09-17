<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * A seasonal override of a return policy, for example used for holidays.
 */
#[Type('MerchantReturnPolicySeasonalOverride')]
final class MerchantReturnPolicySeasonalOverride extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'endDate',
        'identifier',
        'image',
        'mainEntityOfPage',
        'merchantReturnDays',
        'name',
        'owner',
        'potentialAction',
        'refundType',
        'restockingFee',
        'returnFees',
        'returnMethod',
        'returnPolicyCategory',
        'returnShippingFeesAmount',
        'sameAs',
        'startDate',
        'subjectOf',
        'url',
    ];
}
