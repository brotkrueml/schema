<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manual\Publisher;

/**
 * A MerchantReturnPolicy provides information about product return policies associated with an Organization, Product, or Offer.
 */
#[Type('MerchantReturnPolicy')]
#[Manual(Publisher::Google, 'Merchant listing: Returns', 'https://developers.google.com/search/docs/appearance/structured-data/merchant-listing#merchant-return-policy-properties')]
final class MerchantReturnPolicy extends AbstractType
{
    protected static array $propertyNames = [
        'additionalProperty',
        'additionalType',
        'alternateName',
        'applicableCountry',
        'customerRemorseReturnFees',
        'customerRemorseReturnLabelSource',
        'customerRemorseReturnShippingFeesAmount',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'inStoreReturnsOffered',
        'itemCondition',
        'itemDefectReturnFees',
        'itemDefectReturnLabelSource',
        'itemDefectReturnShippingFeesAmount',
        'mainEntityOfPage',
        'merchantReturnDays',
        'merchantReturnLink',
        'name',
        'owner',
        'potentialAction',
        'refundType',
        'restockingFee',
        'returnFees',
        'returnLabelSource',
        'returnMethod',
        'returnPolicyCategory',
        'returnPolicyCountry',
        'returnPolicySeasonalOverride',
        'returnShippingFeesAmount',
        'sameAs',
        'subjectOf',
        'url',
        'validForMemberTier',
    ];
}
