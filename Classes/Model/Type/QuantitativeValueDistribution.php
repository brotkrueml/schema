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
 * A statistical distribution of values.
 */
final class QuantitativeValueDistribution extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'duration' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'median' => null,
        'name' => null,
        'percentile10' => null,
        'percentile25' => null,
        'percentile75' => null,
        'percentile90' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
    ];
}
