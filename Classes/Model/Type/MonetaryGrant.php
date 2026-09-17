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
 * A monetary grant.
 */
#[Type('MonetaryGrant')]
final class MonetaryGrant extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'amount',
        'description',
        'disambiguatingDescription',
        'fundedItem',
        'funder',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'sponsor',
        'subjectOf',
        'url',
    ];
}
