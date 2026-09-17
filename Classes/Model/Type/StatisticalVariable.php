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
 * StatisticalVariable represents any type of statistical metric that can be measured at a place and time. The usage pattern for StatisticalVariable is typically expressed using Observation with an explicit populationType, which is a type, typically drawn from Schema.org. Each StatisticalVariable is marked as a ConstraintNode, meaning that some properties (those listed using constraintProperty) serve in this setting solely to define the statistical variable rather than literally describe a specific person, place or thing. For example, a StatisticalVariable Median_Height_Person_Female representing the median height of women, could be written as follows: the population type is Person; the measuredProperty height; the statType median; the gender Female. It is important to note that there are many kinds of scientific quantitative observation which are not fully, perfectly or unambiguously described following this pattern, or with solely Schema.org terminology. The approach taken here is designed to allow partial, incremental or minimal description of StatisticalVariables, and the use of detailed sets of entity and property IDs from external repositories. The measurementMethod, unitCode and unitText properties can also be used to clarify the specific nature and notation of an observed measurement.
 */
#[Type('StatisticalVariable')]
final class StatisticalVariable extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'constraintProperty',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'measuredProperty',
        'measurementDenominator',
        'measurementMethod',
        'measurementQualifier',
        'measurementTechnique',
        'name',
        'numConstraints',
        'owner',
        'populationType',
        'potentialAction',
        'sameAs',
        'statType',
        'subjectOf',
        'url',
    ];
}
