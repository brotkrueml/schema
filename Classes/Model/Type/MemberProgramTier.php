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
 * A MemberProgramTier specifies a tier under a loyalty (member) program, for example "gold".
 */
#[Type('MemberProgramTier')]
#[Manual(Publisher::Google, 'Loyalty program', 'https://developers.google.com/search/docs/appearance/structured-data/loyalty-program#memberprogram-tier-properties')]
final class MemberProgramTier extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'hasTierBenefit',
        'hasTierRequirement',
        'identifier',
        'image',
        'isTierOf',
        'mainEntityOfPage',
        'membershipPointsEarned',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
