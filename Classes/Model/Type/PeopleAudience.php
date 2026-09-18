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
 * A set of characteristics belonging to people, e.g. who compose an item's target audience.
 */
#[Type('PeopleAudience')]
#[Manual(Publisher::Google, 'Merchant listing: Offer details', 'https://developers.google.com/search/docs/appearance/structured-data/merchant-listing#people-audience-properties')]
final class PeopleAudience extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'audienceType',
        'description',
        'disambiguatingDescription',
        'geographicArea',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'requiredGender',
        'requiredMaxAge',
        'requiredMinAge',
        'sameAs',
        'subjectOf',
        'suggestedAge',
        'suggestedGender',
        'suggestedMaxAge',
        'suggestedMeasurement',
        'suggestedMinAge',
        'url',
    ];
}
