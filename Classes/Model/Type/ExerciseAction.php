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
 * The act of participating in exertive activity for the purposes of improving health and fitness.
 */
#[Type('ExerciseAction')]
final class ExerciseAction extends AbstractType
{
    protected static array $propertyNames = [
        'actionStatus',
        'additionalType',
        'agent',
        'alternateName',
        'audience',
        'description',
        'disambiguatingDescription',
        'distance',
        'endTime',
        'error',
        'event',
        'exerciseCourse',
        'fromLocation',
        'identifier',
        'image',
        'instrument',
        'location',
        'mainEntityOfPage',
        'name',
        'object',
        'opponent',
        'participant',
        'potentialAction',
        'result',
        'sameAs',
        'sportsActivityLocation',
        'sportsEvent',
        'sportsTeam',
        'startTime',
        'subjectOf',
        'target',
        'toLocation',
        'url',
    ];
}
