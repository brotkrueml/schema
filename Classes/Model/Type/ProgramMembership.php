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
 * Used to describe membership in a loyalty programs (e.g. "StarAliance"), traveler clubs (e.g. "AAA"), purchase clubs ("Safeway Club"), etc.
 */
#[Type('ProgramMembership')]
final class ProgramMembership extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'hostingOrganization',
        'identifier',
        'image',
        'mainEntityOfPage',
        'member',
        'membershipNumber',
        'name',
        'potentialAction',
        'program',
        'programName',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
