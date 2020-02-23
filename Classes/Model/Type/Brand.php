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
 * A brand is a name used by an organization or business person for labeling a product, product group, or similar.
 */
final class Brand extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'logo' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'review' => null,
        'sameAs' => null,
        'slogan' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
