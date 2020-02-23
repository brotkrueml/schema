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

/**
 * Used to describe membership in a loyalty programs (e.g. &quot;StarAliance&quot;), traveler clubs (e.g. &quot;AAA&quot;), purchase clubs (&quot;Safeway Club&quot;), etc.
 */
final class ProgramMembership extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'hostingOrganization' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'member' => null,
        'membershipNumber' => null,
        'name' => null,
        'potentialAction' => null,
        'programName' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
