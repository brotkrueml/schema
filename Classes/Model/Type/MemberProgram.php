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
 * A MemberProgram defines a loyalty (or membership) program that provides its members with certain benefits, for example better pricing, free shipping or returns, or the ability to earn loyalty points. Member programs may have multiple tiers, for example silver and gold members, each with different benefits.
 */
#[Type('MemberProgram')]
#[Manual(Publisher::Google, 'Loyalty program', 'https://developers.google.com/search/docs/appearance/structured-data/loyalty-program#member-program-properties')]
final class MemberProgram extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'hasTiers',
        'hostingOrganization',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
