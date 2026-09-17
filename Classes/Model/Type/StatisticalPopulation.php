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
 * A StatisticalPopulation is a set of instances of a certain given type that satisfy some set of constraints. The property populationType is used to specify the type. Any property that can be used on instances of that type can appear on the statistical population. For example, a StatisticalPopulation representing all Persons with a homeLocation of East Podunk California would be described by applying the appropriate homeLocation and populationType properties to a StatisticalPopulation item that stands for that set of people.
 * The properties numConstraints and constraintProperty are used to specify which of the populations properties are used to specify the population. Note that the sense of "population" used here is the general sense of a statistical
 * population, and does not imply that the population consists of people. For example, a populationType of Event or NewsArticle could be used. See also Observation, where a populationType such as Person or Event can be indicated directly. In most cases it may be better to use StatisticalVariable instead of StatisticalPopulation.
 */
#[Type('StatisticalPopulation')]
final class StatisticalPopulation extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'populationType',
        'potentialAction',
        'sameAs',
        'subjectOf',
        'url',
    ];
}
