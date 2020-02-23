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
 * An EndorsementRating is a rating that expresses some level of endorsement, for example inclusion in a &quot;critic\&#039;s pick&quot; blog, a
 */
final class EndorsementRating extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'author' => null,
        'bestRating' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'ratingValue' => null,
        'reviewAspect' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
        'worstRating' => null,
    ];
}
