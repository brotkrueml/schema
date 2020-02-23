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
 * An intangible item that describes an alignment between a learning resource and a node in an educational framework.
 */
final class AlignmentObject extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alignmentType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'educationalFramework' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'targetDescription' => null,
        'targetName' => null,
        'targetUrl' => null,
        'url' => null,
    ];
}
