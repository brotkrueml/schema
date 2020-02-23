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
 * The act of participating in exertive activity for the purposes of improving health and fitness.
 */
final class ExerciseAction extends AbstractType
{
    protected $properties = [
        'actionStatus' => null,
        'additionalType' => null,
        'agent' => null,
        'alternateName' => null,
        'audience' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'distance' => null,
        'endTime' => null,
        'error' => null,
        'event' => null,
        'exerciseCourse' => null,
        'fromLocation' => null,
        'identifier' => null,
        'image' => null,
        'instrument' => null,
        'location' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'object' => null,
        'opponent' => null,
        'participant' => null,
        'potentialAction' => null,
        'result' => null,
        'sameAs' => null,
        'sportsActivityLocation' => null,
        'sportsEvent' => null,
        'sportsTeam' => null,
        'startTime' => null,
        'subjectOf' => null,
        'target' => null,
        'toLocation' => null,
        'url' => null,
    ];
}
