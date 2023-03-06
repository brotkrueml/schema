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
 * A permit issued by an organization, e.g. a parking pass.
 */
#[Type('Permit')]
final class Permit extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'issuedBy',
        'issuedThrough',
        'mainEntityOfPage',
        'name',
        'permitAudience',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
        'validFor',
        'validFrom',
        'validIn',
        'validUntil',
    ];
}
