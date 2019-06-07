<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * The act of participating in exertive activity for the purposes of improving health and fitness.
 *
 * schema.org version 3.6
 */
class ExerciseActionViewHelper extends PlayActionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('distance', 'mixed', 'The distance travelled, e.g. exercising or travelling.');
        $this->registerArgument('exerciseCourse', 'mixed', 'A sub property of location. The course where this action was taken.');
        $this->registerArgument('fromLocation', 'mixed', 'A sub property of location. The original location of the object or the agent before the action.');
        $this->registerArgument('opponent', 'mixed', 'A sub property of participant. The opponent on this action.');
        $this->registerArgument('sportsActivityLocation', 'mixed', 'A sub property of location. The sports activity location where this action occurred.');
        $this->registerArgument('sportsEvent', 'mixed', 'A sub property of location. The sports event where this action occurred.');
        $this->registerArgument('sportsTeam', 'mixed', 'A sub property of participant. The sports team that participated on this action.');
        $this->registerArgument('toLocation', 'mixed', 'A sub property of location. The final location of the object or the agent after the action.');
    }
}
