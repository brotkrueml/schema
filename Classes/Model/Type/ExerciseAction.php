<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class ExerciseAction extends PlayAction
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('distance', 'exerciseCourse', 'fromLocation', 'opponent', 'sportsActivityLocation', 'sportsEvent', 'sportsTeam', 'toLocation');
    }
}
