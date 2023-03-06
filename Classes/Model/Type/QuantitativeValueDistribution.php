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
 * A statistical distribution of values.
 */
#[Type('QuantitativeValueDistribution')]
final class QuantitativeValueDistribution extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'duration',
        'identifier',
        'image',
        'mainEntityOfPage',
        'median',
        'name',
        'percentile10',
        'percentile25',
        'percentile75',
        'percentile90',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
